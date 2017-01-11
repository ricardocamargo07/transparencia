<?php

namespace App\Http\Controllers;

use Cache as IlluminateCache;

class Cache extends Controller
{
    public function clear($key = null)
    {
        if ($key) {
            IlluminateCache::forget($key);

            return $this->response();
        }

        IlluminateCache::flush();

        return $this->response();
    }

    private function response()
    {
        return redirect()->back();
    }
}
