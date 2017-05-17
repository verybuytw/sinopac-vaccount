<?php

namespace Tests\Payment\SinoPac;

use Tests\Payment\SinoPac\AbstractTestCase;
use VeryBuy\Payment\SinoPac\Requests\CloseCaseResponseRequest;
use VeryBuy\Payment\SinoPac\ResponseVerifier;
use VeryBuy\Payment\SinoPac\SinoPacContract;

class CloseCaseResponseRequestTest extends AbstractTestCase
{
    /**
     * @var ResponseVerifier
     */
    protected $verifier;

    /**
     * sinopac auto push xml string
     *
     * @var string
     */
    protected $authPushStub = '<?xml version="1.0"?><CloseCaseRequest><OrderID>T20170516202504</OrderID><ShopNO>AB0178</ShopNO><KeyNum>1</KeyNum><TSNO>AB01780000020</TSNO><TSDate>20170516202509</TSDate><PayDate>20170516203001</PayDate><Amount>1230000</Amount><PayType>A</PayType><RefundFlag>N</RefundFlag><Param1></Param1><Param2></Param2><Param3></Param3></CloseCaseRequest>';

    public function setUp()
    {
        parent::setUp();

        $this->verifier = new ResponseVerifier($this->authPushStub);
    }

    /**
     * @test
     */
    public function 測試回應永豐AuthPush格式正確()
    {
        $verifier = $this->verifier;

        $successRequest = (new CloseCaseResponseRequest([
            'OrderID' => $verifier->getOrderNumber(),
            'ShopNO' => $verifier->getCompanyId(),
            'TSNO' => $verifier->getId(),
            'Amount' => $verifier->getAmount(),
        ]))->success();

        $failedRequest = (new CloseCaseResponseRequest([
            'OrderID' => $verifier->getOrderNumber(),
            'ShopNO' => $verifier->getCompanyId(),
            'TSNO' => $verifier->getId(),
            'Amount' => $verifier->getAmount(),
        ]))->failed();

        // dump($verifier->toXml($successRequest));
        // dump($verifier->toXml($failedRequest));
    }
}
