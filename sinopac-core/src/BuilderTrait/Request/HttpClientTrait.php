<?php

namespace VeryBuy\Payment\SinoPac\BuilderTrait\Request;

use GuzzleHttp\Client;

trait HttpClientTrait
{
    /**
     * @var Client|null
     */
    protected $client;

    /**
     * @param  array        $options
     * @param  Closure|null $callback
     * @return Client
     */
    protected function getClient(array $options = []): Client
    {
        return $this->client ?? $this->client = $this->genClient($options);
    }

    /**
     * @param  array  $options
     * @return Client
     */
    protected function genClient(array $options = []): Client
    {
        return (new Client($options));
    }
}
