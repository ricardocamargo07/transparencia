<?php

namespace App\Jobs;

use Cache;
use App\Support\DataRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CacheRequest implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    public $data;

    public $result;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct(DataRequest $data, $result)
    {
        $this->data = $data;

        $this->result = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->data->cacheEnabled = false;

        $object = app($this->data->class);

        $requester = $object->getRequester($this->data);

        $this->result = $this->result ?: $requester(false);

        Cache::forever($this->data->getKey(), $this->result);
    }
}
