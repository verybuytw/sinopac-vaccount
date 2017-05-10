<?php

namespace VeryBuy\Payment\SinoPac;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface InterfaceRequest extends Arrayable, Jsonable
{
    /**
     * @return string
     */
    public function getUri(): string;
}
