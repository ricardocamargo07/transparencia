<?php

namespace App\Support;

use Cache;
use GuzzleHttp\Client as Guzzle;

trait RemotelyRequestable
{
    use Encodable;

    protected function requestJson($url, $parameters = [], $method = 'GET')
    {
        $url = $this->makeUrl($url, $parameters);

        return Cache::remember($url, config('app.data_cache_time'), function () use ($url, $method) {
            $client = new Guzzle();

            $response = $client->request($method, $url);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            return $this->xmlToJson($response->getBody());
        }
        );
    }

    protected function xmlToJson($xml)
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

    private function makeUrl($url, $parameters)
    {
        $parameters = collect((array) $parameters)->map(function ($item) {
            return $this->encode($item);
        })->toArray();

        return vsprintf($url, $parameters);
    }
}
