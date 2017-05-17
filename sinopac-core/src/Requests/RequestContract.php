<?php

namespace VeryBuy\Payment\SinoPac\Requests;

use VeryBuy\Payment\SinoPac\Exceptions\InvalidArgumentException;
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
    protected $options = [];

    /**
     * @param array       $options
     * @param string|null $uri
     */
    public function __construct(array $options, string $uri = null)
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
        $this->options = $this->options + $options;

        return $this;
    }

    /**
     * @param string $uri
     */
    protected function setUri(string $uri = null): self
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
     * @param  array  $fields
     * @return self|InvalidArgumentException
     */
    protected function validFieldExists(array $fields = []): self
    {
        foreach ($fields as $field) {
            if (!array_key_exists($field, $this->options)) {
                throw new InvalidArgumentException(strtr('{field} is not exists.', [
                    '{field}' => $field
                ]));
            }
        }

        return $this;
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
