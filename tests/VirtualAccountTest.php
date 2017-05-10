<?php

namespace Tests\Payment\SinoPac\VirtualAccount;

use VeryBuy\Payment\SinoPac\RequestBuilder;
use VeryBuy\Payment\SinoPac\SinoPacContract;
use VeryBuy\Payment\SinoPac\VirtualAccount\VirtualAccount;

class VirtualAccountTest extends AbstractTestCase
{
    protected $companyStub = 'AB0178';

    protected $keyStub = [
        'KeyData1' => '7ef61f50-ed9f-4321-b6a2-f60bdafc1e2e',
        'KeyData2' => 'cd3d5255-799e-4210-b9df-1fe3f85d9a55',
        'KeyData3' => 'e640acf0-be7e-4805-9aed-2a52d882cde4'
    ];

    /**
     * @test
     */
    public function 測試虛擬帳號格式正確()
    {
        $request = new VirtualAccount(
            SinoPacContract::REQUEST_VACCOUNT_TEST, [
                // 'OrderNo' => 'T'.date('YmdHis'),
                'OrderNo' => 'T20170510184000',
                'Amount' => 1230000, // 只能 <= 30,000.00
                'PrdtName' => 'test', // 收款名稱只能中英文不能特殊符號最大60字元
                'ExpireDate' => date('Ymd', strtotime('+30 days')) // 設至日期需 <= d+30
            ]
        );

        // $request->validate();

        $builder = (new RequestBuilder(
            $this->companyStub,
            $this->keyStub
        ))->request($request);
    }
}
