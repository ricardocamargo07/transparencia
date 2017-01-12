<?php

namespace App;

use Cache;

abstract class BaseArrayModel
{
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
}

