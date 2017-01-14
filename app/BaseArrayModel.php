<?php

namespace App;

use Cache;

abstract class BaseArrayModel
{
    const CACHE_KEY = 'transparency-data';

    protected $data;

    public function __construct()
    {
        $this->loadData();
    }

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
        return $this->data;
    }

    protected function loadData()
    {
        $this->data = Cache::remember(self::CACHE_KEY, $this->getCacheTime(), function () {
            return $this->loadAllData();
        });
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
}
