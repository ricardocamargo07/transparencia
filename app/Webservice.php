<?php

namespace App;

use Cache;
use HTMLPurifier;
use Carbon\Carbon;
use HTMLPurifier_Config;
use GuzzleHttp\Client as Guzzle;

class Webservice
{
    private $purifier;

    private $requestCache;

    private $rawData;

    protected $data;

    public function __construct($rawData = null)
    {
        $this->rawData = $rawData;

        $this->initializePurifier();
    }

    public function convertDate($date)
    {
        if (! $date) {
            return null;
        }

        return Carbon::parse($date);
    }

    private function dataIsNeeded($slug)
    {
        return $this->rawData->where('slug', $slug)->count();
    }

    private function getData()
    {
        return $this->data;
    }

    public function getFiles($id)
    {
        return $this->toFiles($this->requestJson(config('app.webservice.urls.files'), $id));
    }

    private function getIcon($slug)
    {
        return "/images/icons/$slug.svg";
    }

    private function initializePurifier()
    {
        $config = HTMLPurifier_Config::createDefault();

        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', '%^(http.?:)?//alerjln1.alerj.rj.gov.br%');

        $this->purifier = new HTMLPurifier($config);
    }

    private function makeData($item)
    {
        return [
            'id' => $id = $item['idInformacao'],
            'data_id' => $data_id = $item['categoria']['idCategoria'],
            'title' => $item['titulo'],
            'body' => $item['texto'],
            'user_id' => $item['idUsuario'],
            'html' => $this->purify(isset($item['texto_html']) ? $item['texto_html'] : ''),
            'link' => route('report', [$id]),
            'published_at_string' => $item['data_pub'],
            'published_at' => $this->convertDate($item['data_pub']),
            'status' => $item['status'] == 'S',
            'url' => $item['url'],
            'schedule_start' => $item['agendar_in'] == 'S',
            'schedule_end' => $item['agendar_out'] == 'S',
            'start_date' => $this->convertDate($item['data_agenda_in']),
            'end_date' => $this->convertDate($item['data_agenda_out']),
            'redirect_file' => $item['redireciona_arquivo'] == 'S',
            'data' => [
                'id' => $item['categoria']['idCategoria'],
                'title' => $item['categoria']['nome'],
                'published_at_string' => $item['data_pub'],
                'published_at' => $this->convertDate($item['data_pub']),
                'status' => $item['categoria']['status'] == 'S',
            ],
        ];
    }

    private function makeFileUrl($id)
    {
        return $this->makeUrl(
            config('app.webservice.urls.file'),
            $id
        );
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
                'id' => 'file-' . $id = $item['idArquivo'],
                'title' => $item['titulo'],
                'name' => $item['arquivo'],
                'status' => $item['status'] == 'S',
                'contents_id' => $item['idConteudo'],
                'user_id' => $item['idUsuario'],
                'type' => $item['tipo'],
                'published_at_string' => $item['data_pub'],
                'published_at' => $this->convertDate($item['data_pub']),
                'year' => $item['anoRef'],
                'period' => $item['periodoRef'],
                'period_type' => $item['tipoPeriodoRef'],
                'url' => $this->makeFileUrl($id),
            ];
        })->where('status', 'S')->groupBy('year')->sortByDesc(function($item, $key) {
            return $key;
        });

        return $files;
    }

    private function toData($data)
    {
        info('--------------------------------------------------');
        return collect($data)->where('status', 'S')->map(function ($item) {
            $slug = str_slug($name = $item['nome']);

            info($slug);

            if (! $this->dataIsNeeded($slug)) {
                return null;
            }

            return [
                'id' => $data_id = $item['idCategoria'],
                'title' => $name,
                'slug' => $slug = str_slug($name),
                'icon' => $this->getIcon($slug),
                'links' => $this->getLinks($item['informacoes']),
                'published_at_string' => $published_at = $item['data_pub'],
                'published_at' => $this->convertDate($published_at),
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

    private function getLinks($links)
    {
        return collect($links)->where('status', 'S')->map(function ($item) {
            return $this->makeData($item);
        })->toArray();
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

        return Cache::remember($url, config('app.data_cache_time'), function() use ($url, $method) {
            $client = new Guzzle();

            $response = $client->request($method, $url);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            return $this->xmlToJson($response->getBody());
            }
        );
    }

    public function loadAllData()
    {
        $this->data = $this->toData(
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
