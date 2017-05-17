<?php

namespace VeryBuy\Payment\SinoPac;

use Carbon\Carbon;
use VeryBuy\Payment\SinoPac\BuilderTrait\Response\NormalTrait as Normal;
use VeryBuy\Payment\SinoPac\Responses\ResponseContract;
use VeryBuy\Payment\SinoPac\TransformToXmlTrait as TransformToXml;

class ResponseVerifier extends ResponseContract
{
    use Normal, TransformToXml;

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->parsed->OrderID;
    }

    /**
     * @return string
     */
    public function getTradedAt(): string
    {
        return Carbon::parse($this->parsed->TSDate)->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getPaidAt(): string
    {
        return Carbon::parse($this->parsed->PayDate)->format('Y-m-d H:i:s');
    }

    /**
     * @return boolean
     */
    public function isATM(): bool
    {
        return ($this->getPayType() === SinoPacContract::PAYTYPE_ATM);
    }

    /**
     * @return boolean
     */
    public function isCreditCard(): bool
    {
        return ($this->getPayType() === SinoPacContract::PAYTYPE_CREDITCARD);
    }

    /**
     * @return boolean
     */
    public function isRefund(): bool
    {
        return ($this->parsed->RefundFlag === SinoPacContract::RESPONSE_AUTOPUSH_REFUND);
    }

    /**
     * @return string
     */
    protected function getPayType(): string
    {
        return $this->parsed->PayType;
    }
}
