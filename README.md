Installation
-------------

```shell
$    composer require hughes/sinopac-vaccount
```

### Use RequestBuilder make a request to get sinopac virtual account

```php
<?php

    use VeryBuy\Payment\SinoPac\RequestBuilder;
    use VeryBuy\Payment\SinoPac\VirtualAccount\VirtualAccountRequest;
    use VeryBuy\Payment\SinoPac\SinoPacContract;

    $request = new VirtualAccountRequest(
        SinoPacContract::REQUEST_VACCOUNT_TEST, [
            'OrderNO' => 'T'.date('YmdHis'),                    // 訂單編號
            'Amount' => 1230000,                                // 只能 <= 30,000.00
            'ExpireDate' => date('Ymd', strtotime('+30 days')), // 設至日期需 <= d+30
            'PrdtName' => 'test',                               // 收款名稱只能中英文不能特殊符號最大60字元
        ]
    );

    $companyId = 'AB0178'; // 商家代碼

    $vaccount = (new RequestBuilder($companyId, [
        'KeyData1' => '7ef61f50-ed9f-4321-b6a2-f60bdafc1e2e',
        'KeyData2' => 'cd3d5255-799e-4210-b9df-1fe3f85d9a55',
        'KeyData3' => 'e640acf0-be7e-4805-9aed-2a52d882cde4'
    ]))->make($request)->getVirtualAccount();
```

## Auto push

### Use ResponseVerifier verify response

```php
<?php
    use VeryBuy\Payment\SinoPac\ResponseVerifier;

    $verifier = new ResponseVerifier({response xml string});

    $verifier->getTradedAt();       // 交易時間
    $verifier->getPaidAt();         // 付款時間
    $verifier->getAmount();         // 付款金額
    $verifier->getOrderNumber();    // 訂單編號
    $verifier->getId();             // 永豐自訂 id
```

### Response for sinopac auto push

```php
<?php

    use VeryBuy\Payment\SinoPac\ResponseVerifier;
    use VeryBuy\Payment\SinoPac\Requests\CloseCaseResponseRequest;

    $verifier = new ResponseVerifier({response xml string});

    /**
     * auto push response success xml
     */
    $success = (new CloseCaseResponseRequest([
        'OrderID' => $verifier->getOrderNumber(),
        'ShopNO' => $verifier->getCompanyId(),
        'TSNO' => $verifier->getId(),
        'Amount' => $verifier->getAmount(),
    ]))->success();

    $verifier->toXml($success);

    /**
     * auto push response success xml
     */
    $failed = (new CloseCaseResponseRequest([
        'OrderID' => $verifier->getOrderNumber(),
        'ShopNO' => $verifier->getCompanyId(),
        'TSNO' => $verifier->getId(),
        'Amount' => $verifier->getAmount(),
    ]))->failed();

    $verifier->toXml($failed);
```
