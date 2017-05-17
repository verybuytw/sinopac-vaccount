<?php

namespace Tests\Payment\SinoPac;

use Tests\Payment\SinoPac\AbstractTestCase;
use Tests\Payment\SinoPac\ConfigTrait;
use VeryBuy\Payment\SinoPac\RequestBuilder;
use VeryBuy\Payment\SinoPac\Requests\QueryTradeStatusRequest;
use VeryBuy\Payment\SinoPac\SinoPacContract;

class QueryTradeStatusRequestTest extends AbstractTestCase
{
    use ConfigTrait;

    /**
     * @test
     */
    public function 測試虛擬帳號格式正確()
    {
        $response = (new RequestBuilder(
            $this->companyStub,
            $this->keyStub)
        )->make(new QueryTradeStatusRequest(
            [
                'PayType' => SinoPacContract::PAYTYPE_ATM,
                'OrderDateS' => null,
                'OrderTimeS' => null,
                'OrderDateE' => null,
                'OrderTimeE' => null,
                'PayFlag' => SinoPacContract::PAYFLAG_ATM_ALL,
            ],
            SinoPacContract::REQUEST_QUERY_TRADE_STATUS_TEST
        ));

        // dump($response);
    }
}
