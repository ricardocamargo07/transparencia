<?php

namespace App;

use DB;
use DateTime;
use App\Support\Datable;
use App\Support\Cacheable;
use App\Support\DataRequest;
use App\Support\RemotelyRequestable;

class Protocol
{
    use RemotelyRequestable, Datable, Cacheable;

    protected $cacheEnabled = false;

    private function createAllAlternatives($id)
    {
        $id = preg_replace('/[^0-9-.\/]/', '', $id);

        list($number, $year) = explode('/', $id);

        return [
            'years' => $this->getYears($year),
            'numbers' => $this->getNumbers($number)
        ];
    }

    private function extractNumberYear($number)
    {
        $number = str_replace(' ', '/', $number);
        $number = str_replace('\\', '/', $number);
        $number = str_replace('-', '/', $number);

        list($number, $year) = explode('/', $number);

        $number = preg_replace('/\D/', '', $number);
        $year = preg_replace('/\D/', '', $year);

        return [$number, $year];
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

    public function findByGeneralProtocol($number)
    {
        return $this->findGeneralProtocol($number);
    }

    public function findByProtocol($id)
    {
        return $this->toProtocol(
            $this->findProtocol($id)
        );
    }

    private function findGeneralProtocol($number)
    {
        list($number, $year) = $this->extractNumberYear($number);

        $connection = DB::connection('alerj');

        $connection->statement('SET ANSI_NULLS ON; SET ANSI_WARNINGS ON;');

        $protocol = $connection->select(DB::raw("select * from sy_vw_autor_processo where ano = {$year} and numero = {$number}"));

        return $protocol
                ? json_decode(json_encode($protocol), true)[0]
                : false;
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

        if (isset($data['idConteudo'])) {
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

        return $data;
    }

    private function toYear($year, $type)
    {
        $dt = DateTime::createFromFormat($type == 'Y' ? 'y' : 'Y', $year);

        if ($dt) {
            return $dt->format($type);
        }
    }

    public function getRequester($data = null) {
        return $this->getGuzzleXmlRequester($data);
    }
}
