<?php

namespace App;

use DateTime;
use App\Support\Datable;
use App\Support\DataRequest;
use App\Support\RemotelyRequestable;

class Protocol extends Data
{
    use RemotelyRequestable, Datable;

    private function createAllAlternatives($id)
    {
        $id = preg_replace('/[^0-9-.\/]/', '', $id);

        list($number, $year) = explode('/', $id);

        return [
            'years' => $this->getYears($year),
            'numbers' => $this->getNumbers($number)
        ];
    }

    /**
     * @param $id
     * @return null
     */
    private function findAlternatives($id)
    {
        $codes = $this->createAllAlternatives($id);

        foreach ($codes['years'] as $year) {
            foreach ($codes['numbers'] as $number) {
                if ($found = $this->findRequest("$number/$year")) {
                    return $found;
                }
            }
        }

        return null;
    }

    public function findByProtocol($id)
    {
        return $this->toProtocol(
            $this->findProtocol($id)
        );
    }

    private function findProtocol($id)
    {
        $id = $this->decode($id);

        if ($found = $this->findRequest($id)) {
            return $found;
        }

        return $this->findAlternatives($id);
    }

    private function findRequest($id)
    {
        $data = new DataRequest(
            static::class,
            config('app.webservice.urls.protocol'),
            'GET',
            [$id]
        );

        return $this->requestJson($data);
    }

    private function getNumbers($number)
    {
        $result = [
            $number,
            $digits = preg_replace('/\D/', '', $number),
        ];

        foreach (range(1, strlen($digits)-1) as $pos) {
            $result[] = substr($digits, 0, $pos).'.'.substr($digits, $pos);
        }

        return $result;
    }

    /**
     * @param $year
     */
    private function getYears($year)
    {
        return [
            $year,
            ($year > 1900)
                ? $this->toYear($year, 'y')
                : $this->toYear($year, 'Y')
        ];
    }

    private function toProtocol($data)
    {
        if (count($data) == 0) {
            return null;
        }

        $data = $data[0];

        return [
            'id' => $data['idConteudo'],
            'protocol' => $data['protocolo'],
            'name' => $data['nome'],
            'created_at' => $this->convertDate($data['data_pergunta']),
            'published_at' => $this->convertDate($data['data_pub']),
            'question' => $data['pergunta'],
            'answer' => $data['resposta'],
            'status' => $data['status'] == 'S',
            'person_id' => $data['identidade'],
            'user_id' => $data['idUsuario'],
            'featured' => $data['destaque'] == 'S',
        ];
    }

    private function toYear($year, $type)
    {
        $dt = DateTime::createFromFormat($type == 'Y' ? 'y' : 'Y', $year);

        return $dt->format($type);
    }
}
