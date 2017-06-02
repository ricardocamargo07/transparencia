<?php

namespace App\Support;

class DataRequest
{
    /**
     * @var string
     */
    public $method = 'GET';

    /**
     * @var string
     */
    public $url;

    /**
     * @var
     */
    public $class;

    /**
     * @var
     */
    public $cacheEnabled = true;

    /**
     * @var string
     */
    public $parameters = [];

    /**
     * DataRequest constructor.
     * @param $class
     * @param string $url
     * @param string $method
     * @param string $parameters
     */
    public function __construct($class, $url = null, $method = 'GET', $parameters = [])
    {
        $this->class = $class;

        $this->url = $url;

        $this->method = $method;

        $this->parameters = $parameters;
    }

    public function getKey()
    {
        return 'url:' . ($this->url ?: '/') . ' - ' .
               'class:' . $this->class . ' - ' .
               'method:' . $this->method;
    }

    public function setCacheEnabled($enabled)
    {
        $this->cacheEnabled = $enabled;
    }
}
