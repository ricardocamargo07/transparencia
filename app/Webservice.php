<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;

class Webservice
{
    public function convertDate($date)
    {
        if (! $date) {
            return null;
        }

        return Carbon::createFromFormat('d/m/Y', $date);
    }

    private function getIcon($slug)
    {
        return "/images/icons/$slug.svg";
    }

    private function makeUrl($url, $parameters)
    {
        return vsprintf($url, $parameters);
    }

    private function toFiles($ListaArquivos)
    {
        $files = collect($ListaArquivos)->map(function($item) {
            return [
                'id' => 'file-' . $item['IdArquivo'],
                'title' => $item['Titulo'],
                'name' => $item['NomArquivo'],
                'status' => $item['status'] == 'S',
                'contents' => $item['ConteudoArquivo'],
                'type' => $item['Tipo'],
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'year' => 2016,
                'url' => $item['Url'],
            ];
        })->groupBy('year');

        return $files;
    }

    private function toSections($data)
    {
        $data = collect($data);

        return $data->map(function ($item) {
            /**
             * @param $item
             * @return static
             */
            return [
                'id' => $section_id = $item['IdCategoria'],
                'title' => $item['Nome'],
                'slug' => $slug = str_slug($item['Nome']),
                'icon' => $this->getIcon($slug),
                'links' => $this->getSectionLinks($section_id),
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'status' => $item['status'] == 'S',
            ];
        });
    }

    private function toSection($data)
    {
        $data = collect($data);

        return $data->map(function ($item) {
            return [
                'id' => $report_id = $item['IdInformacao'],
                'section_id' => $section_id = $item['Categoria']['IdCategoria'],
                'title' => $item['Titulo'],
                'body' => $item['Texto'],
                'html' => isset($item['Html']) ? $item['Html'] : '',
                'link' => route('report', [$report_id]),
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'status' => $item['Status'] == 'S',
                'url' => $item['Url'],
                'schedule_start' => $item['AgendarEntrada'] == 'S',
                'schedule_end' => $item['AgendarSaida'] == 'S',
                'start_date' => $this->convertDate($item['DatAgendaEntrada']),
                'end_date' => $this->convertDate($item['DatAgendaSaida']),
                'redirect_file' => $item['RedirecionaArquivo'] == 'S',
                'section' => [
                    'id' => $item['Categoria']['IdCategoria'],
                    'title' => $item['Categoria']['Nome'],
                    'published_at_string' => $item['DatPublicacao'],
                    'published_at' => $this->convertDate($item['DatPublicacao']),
                    'status' => $item['Categoria']['status'] == 'S',
                ],
                'files' => $this->toFiles($item['ListaArquivos']),
            ];
        });
    }

    private function getSectionLinks($id)
    {
        return $this->toSection($this->requestJson(config('app.webservice.urls.section'), ['id' => $id]))->toArray();
    }

    public function getSection($sectionId)
    {
        return $this->getSections()->where('slug', $sectionId)->values()[0];
    }

    private function requestJson($url, $parameters = [], $method = 'GET')
    {
        $client = new Guzzle();

        $url = $this->makeUrl($url, $parameters);

        $response = $client->request($method, $url);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

       return $this->xmlToJson($response->getBody());
    }

    public function getSections()
    {
        return $this->toSections(
            $this->requestJson(config('app.webservice.urls.all_sections'))
        );
    }

    private function xmlToJson($xml)
    {
        if ($json = json_decode($xml, true)) {
            return $json;
        }

        try {
            $xml = simplexml_load_string($xml);
        } catch (\Exception $exception) {
            return null;
        }

        $json = json_encode($xml);

        return json_decode($json, true);
    }
}
