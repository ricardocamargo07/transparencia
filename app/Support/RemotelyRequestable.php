<?php

namespace App\Support;

use Cache;
use GuzzleHttp\Client as Guzzle;

trait RemotelyRequestable
{
    use Encodable;

    protected function requestJson($data)
    {
        $data->url = $this->makeUrl($data->url, $data->parameters);

        return $this->fetchAndCache($data);
    }

    public function getGuzzleXmlRequester(DataRequest $data) {
        return function () use ($data) {
            $client = new Guzzle();

            $response = $client->request($data->method, $data->url);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            return $this->xmlToJson($response->getBody());
        };
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
