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

        $requested = false;

        if (! $result = Cache::get($data->getKey())) {
            $result = $this->getResult($data);

            $requested = true;
        }

        if (! $requested) {
            dispatch(new CacheRequest($data));
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
