<?php

namespace VeryBuy\Payment\SinoPac\Requests;

use VeryBuy\Payment\SinoPac\Requests\RequestContract;
use VeryBuy\Payment\SinoPac\SinoPacContract;

class CloseCaseResponseRequest extends RequestContract
{
    /**
     * @var string
     */
    protected $status = SinoPacContract::CLOSECASE_STATUS_FAILED;

    /**
     * @return self
     */
    public function success()
    {
        $this->status = SinoPacContract::CLOSECASE_STATUS_SUCCESS;

        return $this;
    }

    /**
     * @return self
     */
    public function failed()
    {
        $this->status = SinoPacContract::CLOSECASE_STATUS_FAILED;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        /**
         * 大小寫需一致，欄位順序也要一致
         */
        return $this->mergeOptions([
            'OrderID' => null,
            'ShopNO' => null,
            'TSNO' => null,
            'Amount' => null,
            'Status' => $this->status,
            'Description' => null,
        ]);
    }

    /**
     * @return self
     */
    public function validate(): self
    {
        return $this->validFieldExists([
            'OrderID', 'ShopNO', 'TSNO', 'Amount', 'Status'
        ]);
    }

    /**
     * @return string
     */
    public function getXmlHeader(): string
    {
        return '<CloseCaseResponse/>';
    }

    /**
     * @return string|LogicException
     */
    public function getResponseClass(): string
    {
        throw new \LogicException('Do not use it.');
    }
}
