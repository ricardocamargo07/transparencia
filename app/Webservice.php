<?php

namespace App;

use HTMLPurifier;
use HTMLPurifier_Config;
use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;

class Webservice
{
    private $purifier;

    private $requestCache;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();

        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', '%^(http.?:)?//alerjln1.alerj.rj.gov.br%');

        $this->purifier = new HTMLPurifier($config);
    }

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

    private function makeData($item)
    {
        return [
            'id' => $report_id = $item['IdInformacao'],
            'data_id' => $data_id = $item['Categoria']['IdCategoria'],
            'title' => $item['Titulo'],
            'body' => $item['Texto'],
            'html' => $this->purify(isset($item['TextoHtml']) ? $item['TextoHtml'] : ''),
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
            'data' => [
                'id' => $item['Categoria']['IdCategoria'],
                'title' => $item['Categoria']['Nome'],
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'status' => $item['Categoria']['status'] == 'S',
            ],
            'files' => $this->toFiles($item['ListaArquivos']),
        ];
    }

    private function makeUrl($url, $parameters)
    {
        return vsprintf($url, $parameters);
    }

    private function purify($html)
    {
        return $this->purifier->purify($html);
    }

    private function requestCache($url, $data = null)
    {
        if ($data) {
            $this->requestCache[$url] = $data;

            return $data;
        }

        if ($data = array_get($this->requestCache, $url)) {
            return $data;
        }

        return null;
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
                'year' => $item['AnoRef'],
                'period' => $item['PeriodoRef'],
                'period_type' => $item['TipoPeriodoRef'],
                'url' => $item['Url'],
            ];
        })->groupBy('year')->sortByDesc(function($item, $key) {
            return $key;
        });

        return $files;
    }

    private function toData($data)
    {
        return collect($data)->map(function ($item) {
            return [
                'id' => $data_id = $item['IdCategoria'],
                'title' => $item['Nome'],
                'slug' => $slug = str_slug($item['Nome']),
                'icon' => $this->getIcon($slug),
                'links' => $this->getLinks($data_id),
                'published_at_string' => $item['DatPublicacao'],
                'published_at' => $this->convertDate($item['DatPublicacao']),
                'status' => $item['status'] == 'S',
            ];
        });
    }

    private function toItem($data)
    {
        return collect($data)->map(function ($item) {
            return $this->makeData($item);
        });
    }

    private function getLinks($id)
    {
        return $this->toItem(
            $this->requestJson(config('app.webservice.urls.section'), ['id' => $id])
        )->toArray();
    }

    public function getItem($item)
    {
        $data = $this->getData()->where('slug', $item['slug'])->values()[0];

        $data['webservice'] = $item;

        return $data;
    }

    private function requestJson($url, $parameters = [], $method = 'GET')
    {
        $url = $this->makeUrl($url, $parameters);

        if ($data = $this->requestCache($url)) {
            return $data;
        }

        $client = new Guzzle();

        $response = $client->request($method, $url);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $data = $this->xmlToJson($response->getBody());

        $this->requestCache($url, $data);

        return $data;
    }

    public function getData()
    {
        return $this->toData(
            $this->requestJson(
                config('app.webservice.urls.all_sections')
            )
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
