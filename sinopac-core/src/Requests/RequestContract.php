<?php

namespace VeryBuy\Payment\SinoPac\Requests;

use VeryBuy\Payment\SinoPac\Requests\CanBeVerified;
use VeryBuy\Payment\SinoPac\Requests\InterfaceRequest;

abstract class RequestContract implements InterfaceRequest, CanBeVerified
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param string $uri
     * @param array $options
     */
    public function __construct($uri, $options)
    {
        $this
            ->setUri($uri)
            ->setOptions($options);
    }

    /**
     * @param array $options
     */
    protected function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $uri
     */
    protected function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param  array  $parameters
     * @return array
     */
    protected function mergeOptions(array $parameters): array
    {
        return array_merge($parameters, $this->options);
    }

    /**
     * @param  integer $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @return string
     */
    abstract public function getXmlHeader(): string;

    /**
     * @return string
     */
    abstract public function getResponseClass(): string;
}
