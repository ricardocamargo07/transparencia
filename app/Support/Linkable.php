<?php

namespace App\Support;

trait Linkable
{
    public function makeUrl($url, $parameters)
    {
        $parameters = collect((array) $parameters)->map(function ($item) {
            return $this->encode($item);
        })->toArray();

        if (count($parameters) == 0) {
            $parameters = ['','','','',''];
        }

        return vsprintf($url, $parameters);
    }

    public function makeFileUrl($id)
    {
        return $this->makeUrl(
            config('app.webservice.urls.file'),
            $id
        );
    }
}
