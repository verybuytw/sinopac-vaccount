<?php

namespace VeryBuy\Payment\SinoPac\Responses;

use SimpleXMLElement;
use VeryBuy\Payment\SinoPac\Responses\InterfaceResponse;
use stdClass;

abstract class ResponseContract implements InterfaceResponse
{
    /**
     * @var string
     */
    protected $xml;

    /**
     * @var SimpleXMLElement
     */
    protected $parsed;

    /**
     * @param HttpResponse $response
     */
    public function __construct(string $xml)
    {
        $this->parsed = $this->parseResponseXmlToObject($xml);
    }

    /**
     * @param  string $xml
     * @return stdClass
     */
    protected function parseResponseXmlToObject(string $xml): stdClass
    {
        $this->xml = $xml;

        return $this->parseXmlToObject(simplexml_load_string($xml));
    }

    /**
     * @param  SimpleXMLElement $xml
     * @return stdClass
     */
    protected function parseXmlToObject(SimpleXMLElement $xml): stdClass
    {
        return json_decode(json_encode($xml));
    }

    /**
     * @return boolean
     */
    public function isSuccess(): bool
    {
        return ($this->parsed->Status === InterfaceResponse::RESPONSE_SUCCESS);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->parsed->Description;
    }
}
