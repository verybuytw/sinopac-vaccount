<?php

namespace Tests\Payment\SinoPac\VirtualAccount;

use Tests\Payment\SinoPac\ConfigTrait;
use VeryBuy\Payment\SinoPac\Exceptions\FailedException;
use VeryBuy\Payment\SinoPac\RequestBuilder;
use VeryBuy\Payment\SinoPac\Response\Response;
use VeryBuy\Payment\SinoPac\SinoPacContract;
use VeryBuy\Payment\SinoPac\VirtualAccount\VirtualAccountRequest;
use VeryBuy\Payment\SinoPac\VirtualAccount\VirtualAccountResponse;

class VirtualAccountRequestTest extends AbstractTestCase
{
    use ConfigTrait;

    protected $xmlSuccessStub = '<ServerResponse xmlns="http://schemas.datacontract.org/2004/07/SinoPacWebAPI.Contract" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><OrderNO>T20170513133815</OrderNO><ShopNO>AB0178</ShopNO><KeyNum>3</KeyNum><TSNO>AB01780000010</TSNO><PayType>A</PayType><PayNO>99936820011366</PayNO><Amount>1230000</Amount><Status>S</Status><Description>S00000</Description><Param1></Param1><Param2></Param2><Param3></Param3></ServerResponse>';

    protected $xmlFailStub = '<ServerResponse xmlns="http://schemas.datacontract.org/2004/07/SinoPacWebAPI.Contract" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><OrderNO>T20170513133815</OrderNO><ShopNO>AB0178</ShopNO><KeyNum>3</KeyNum><TSNO>AB01780000010</TSNO><PayType>A</PayType><PayNO>99936820011366</PayNO><Amount>1230000</Amount><Status>F</Status><Description>E87000</Description><Param1></Param1><Param2></Param2><Param3></Param3></ServerResponse>';

    /**
     * @test
     */
    public function 測試虛擬帳號格式正確()
    {
        /**
         * 大小寫需一致，欄位順序也要一致
         */
        $request = new VirtualAccountRequest(
            SinoPacContract::REQUEST_VACCOUNT_TEST, [
                'OrderNO' => 'T'.date('YmdHis'),
                'Amount' => 1230000, // 只能 <= 30,000.00
                'ExpireDate' => date('Ymd', strtotime('+30 days')), // 設至日期需 <= d+30
                'PrdtName' => 'test', // 收款名稱只能中英文不能特殊符號最大60字元
                // 'Memo' => null,
                // 'PayerName' => null,
                // 'PayerMobile' => null,
                // 'PayerAddress' => null,
                // 'PayerEmail' => null,
                // 'ReceiverName' => null,
                // 'ReceiverMobile' => null,
                // 'ReceiverAddress' => null,
                // 'ReceiverEmail' => null,
                // 'Param1' => null,
                // 'Param2' => null,
                // 'Param3' => null,
            ]
        );

        $account = (new RequestBuilder(
            $this->companyStub,
            $this->keyStub
        ))->make($request)->getVirtualAccount();

        dump($account);
    }

    /**
     * @test
     */
    public function 測試回應資料()
    {
        // dump(new VirtualAccountResponse($this->xmlSuccessStub));
        // dump((new VirtualAccountResponse($this->xmlSuccessStub))->getVirtualAccount());
    }

    /**
     * @test
     */
    public function 測試回應失敗資料FailedException正常解讀()
    {
        $this->expectException(FailedException::class);

        $response = new VirtualAccountResponse($this->xmlFailStub);

        throw new FailedException(
            (new VirtualAccountResponse($this->xmlFailStub))->getCode()
        );
    }
}
