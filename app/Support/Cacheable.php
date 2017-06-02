<?php

namespace App\Support;

use Cache;
use App\Jobs\CacheRequest;

trait Cacheable
{
    /**
     * @param DataRequest $data
     * @return mixed
     */
    protected function fetchAndCache(DataRequest $data)
    {
        if (! $data->cacheEnabled || ! $this->cacheEnabled) {
            return $this->getResult($data);
        }

        $result = Cache::get($key = $data->getKey());

        if ($result === false || is_null($result)) {
            $result = $this->getResult($data);

            Cache::forever($key, $result);
        }

        return $result;
    }

    protected function getResult(DataRequest $data)
    {
        $requester = $this->getRequester($data);

        $result = $requester();

        if ($this->cacheEnabled) {
            Cache::forever($data->getKey(), $result);
        }

        return $result;
    }
}
