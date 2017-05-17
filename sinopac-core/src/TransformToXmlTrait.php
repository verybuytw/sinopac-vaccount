<?php

namespace VeryBuy\Payment\SinoPac;

use SimpleXMLElement;
use VeryBuy\Payment\SinoPac\Exceptions\InvalidArgumentException;
use VeryBuy\Payment\SinoPac\Requests\RequestContract;

trait TransformToXmlTrait
{
    /**
     * @param  array        $array
     * @param  string|null  $header
     * @return string
     */
    public function toXml(...$args): string
    {
        if ($this->isRequestContract($args)) {
            list($instance) = $args;
            $array = $instance->validate()->toArray();
            $header = $instance->getXmlHeader();
        } else {
            list($array, $header) = $args;
        }

        $xml = new SimpleXMLElement($header);

        $this->transformArrayToXml($array, $xml);

        return $xml->asXML();
    }

    /**
     * @param  array            $arr [description]
     * @param  SimpleXMLElement $xml [description]
     * @return SimpleXMLElement
     */
    private function transformArrayToXml(array $array, SimpleXMLElement $xml): SimpleXMLElement
    {
        foreach ($array as $key => $value) {
            is_array($value)
                ? $this->transformArrayToXml($value, $xml->addChild($key))
                : $xml->addChild($key, $value);
        }

        return $xml;
    }

    /**
     * @param  mixed $instance
     * @return boolean
     */
    private function isRequestContract(array $args): bool
    {
        list($instance) = $args;

        return ($instance instanceof RequestContract);
    }
}
