<?php

namespace VeryBuy\Payment\SinoPac\Requests;

use VeryBuy\Payment\SinoPac\Requests\RequestContract;
use VeryBuy\Payment\SinoPac\Responses\QueryTradeStatusResponse;

class QueryTradeStatusRequest extends RequestContract
{
    /**
     * @return array
     */
    public function toArray()
    {
        /**
         * 大小寫需一致，欄位順序也要一致
         */
        return $this->mergeOptions([
            'ShopNO' => null,
            'KeyNum' => null,
            'OrderNO' => null,
            'PayType' => null,
            'OrderDateS' => null,
            'OrderTimeS' => null,
            'OrderDateE' => null,
            'OrderTimeE' => null,
            'PayFlag' => 'A',
            'PrdtNameFlag' => 'N',
            'MemoFlag' => 'N',
            'PayerNameFlag' => 'N',
            'PayerMobileFlag' => 'N',
            'PayerAddressFlag' => 'N',
            'PayerEmailFlag' => 'N',
            'ReceiverNameFlag' => 'N',
            'ReceiverMobileFlag' => 'N',
            'ReceiverAddressFlag' => 'N',
            'ReceiverEmailFlag' => 'N',
            'ParamFlag1' => 'N',
            'ParamFlag2' => 'N',
            'ParamFlag3' => 'N',
            'StagingFlag' => 'N',
            'DividendFlag' => 'N',
        ]);
    }

    /**
     * @return string
     */
    public function getXmlHeader(): string
    {
        return '<QueryTradeStatusRequest xmlns="http://schemas.datacontract.org/2004/07/SinoPacWebAPI.Contract.QueryTradeStatus" />';
    }

    /**
     * @return self
     */
    public function validate(): self
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseClass(): string
    {
        return QueryTradeStatusResponse::class;
    }
}
