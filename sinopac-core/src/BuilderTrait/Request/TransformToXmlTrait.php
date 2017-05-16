<?php

namespace VeryBuy\Payment\SinoPac\BuilderTrait\Request;

use SimpleXMLElement;

trait TransformToXmlTrait
{
    /**
     * @param  array        $array
     * @param  string|null  $header
     * @return string
     */
    public function toXml(...$args): string
    {
        $args = $args ?: [$this->getXmlHeader()];

        list($array, $header) = $args;

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
}
