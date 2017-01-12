<?php

namespace App;

class Item extends Data
{
    public static function findById($id)
    {
        return static::all()->map(function($section) use ($id) {
            if ($first = collect($section['links'])->where('id', $id)->first()) {
                $first['section'] = $section;
            }

            return $first;
        })->filter(function ($item) {
            return $item;
        })->first();
    }
}
