<?php

namespace VeryBuy\Payment\SinoPac\VirtualAccount;

use VeryBuy\Payment\SinoPac\BuilderTrait\Response\NormalTrait as Normal;
use VeryBuy\Payment\SinoPac\Responses\ResponseContract;

class VirtualAccountResponse extends ResponseContract
{
    use Normal;

    /**
     * @return string
     */
    public function getVirtualAccount(): string
    {
        return $this->parsed->PayNO;
    }
}
