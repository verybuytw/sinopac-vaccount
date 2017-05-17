<?php

namespace Tests\Payment\SinoPac;

use Tests\Payment\SinoPac\AbstractTestCase;
use VeryBuy\Payment\SinoPac\ResponseVerifier;

class ResponseVerifierTest extends AbstractTestCase
{
    use ConfigTrait;

    protected $stub = '<?xml version="1.0"?><CloseCaseRequest><OrderID>T20170516202504</OrderID><ShopNO>AB0178</ShopNO><KeyNum>1</KeyNum><TSNO>AB01780000020</TSNO><TSDate>20170516202509</TSDate><PayDate>20170516203001</PayDate><Amount>1230000</Amount><PayType>A</PayType><RefundFlag>N</RefundFlag><Param1></Param1><Param2></Param2><Param3></Param3></CloseCaseRequest>';

    /**
     * @test
     */
    public function 測試銀行回應格式正確()
    {
        $verifier = new ResponseVerifier($this->stub);
    }
}
