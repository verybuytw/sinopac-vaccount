<?php

namespace Tests\Payment\SinoPac\VirtualAccount;

trait ConfigTrait
{
    protected $companyStub = 'AB0178';

    protected $keyStub = [
        'KeyData1' => '7ef61f50-ed9f-4321-b6a2-f60bdafc1e2e',
        'KeyData2' => 'cd3d5255-799e-4210-b9df-1fe3f85d9a55',
        'KeyData3' => 'e640acf0-be7e-4805-9aed-2a52d882cde4'
    ];
}