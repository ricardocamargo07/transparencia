<?php

namespace App;

class Report extends Section
{
    public static function findById($id)
    {
        return static::all()->reduce(function($carry, $section) use ($id) {
            return collect($section['links'])->where('id', $id)->first();
        });
    }
}
