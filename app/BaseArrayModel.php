<?php

namespace App;

use App\Support\DataRequest;
use Cache;
use App\Support\Cacheable;
use App\Support\RemotelyRequestable;

abstract class BaseArrayModel
{
    use RemotelyRequestable, Cacheable;

    const CACHE_KEY = 'transparency-data';

    protected $data;

    private $loaded = false;

    public static function all()
    {
        return (new static())->getData();
    }

    public static function findBySlug($slug)
    {
        return static::all()->where('slug', $slug);
    }

    public static function findById($slug)
    {
        return static::all()->where('id', $slug)->first();
    }

    private function getData()
    {
        return $this->loadData();
    }

    protected function loadData()
    {
        if (! $this->loaded) {
            $this->data = $this->fetchAndCache(
                new DataRequest(get_class($this))
            );

            $this->loaded = true;
        }

        return $this->data;
    }

    public static function update() {
        Cache::put(
            self::CACHE_KEY,
            (new static())->loadAllData(),
            (new static())->getCacheTime()
        );
    }

    protected function getCacheTime()
    {
        return config('app.data_cache_time');
    }

    public function getRequester($data = null) {
        return function () use ($data) {
            return $this->loadAllData($data);
        };
    }
}
