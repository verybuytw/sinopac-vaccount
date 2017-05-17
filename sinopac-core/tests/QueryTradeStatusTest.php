<?php

namespace Tests\Payment\SinoPac;

use Tests\Payment\SinoPac\AbstractTestCase;
use Tests\Payment\SinoPac\ConfigTrait;
use VeryBuy\Payment\SinoPac\RequestBuilder;
use VeryBuy\Payment\SinoPac\Requests\QueryTradeStatusRequest;
use VeryBuy\Payment\SinoPac\SinoPacContract;

class QueryTradeStatusTest extends AbstractTestCase
{
    use ConfigTrait;

    protected $stub = '<?xml version="1.0"?><CloseCaseRequest><OrderID>T20170516202504</OrderID><ShopNO>AB0178</ShopNO><KeyNum>1</KeyNum><TSNO>AB01780000020</TSNO><TSDate>20170516202509</TSDate><PayDate>20170516203001</PayDate><Amount>1230000</Amount><PayType>A</PayType><RefundFlag>N</RefundFlag><Param1></Param1><Param2></Param2><Param3></Param3></CloseCaseRequest>';

    /**
     * @test
     */
    public function 測試虛擬帳號格式正確()
    {
        $response = (new RequestBuilder(
            $this->companyStub,
            $this->keyStub)
        )->make(new QueryTradeStatusRequest(
            SinoPacContract::REQUEST_QUERY_TRADE_STATUS_TEST, [
                'PayType' => SinoPacContract::PAYTYPE_ATM,
                'OrderDateS' => null,
                'OrderTimeS' => null,
                'OrderDateE' => null,
                'OrderTimeE' => null,
                'PayFlag' => SinoPacContract::PAYFLAG_ATM_ALL,
            ]
        ));

        dump($response);
    }
}
