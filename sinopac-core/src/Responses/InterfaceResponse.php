<?php

namespace VeryBuy\Payment\SinoPac\Responses;

interface InterfaceResponse
{
    const RESPONSE_SUCCESS = 'S';
    const RESPONSE_FAILED = 'F';

    /**
     * @return boolean
     */
    public function isSuccess(): bool;

    /**
     * @return string
     */
    public function getCode(): string;
}
