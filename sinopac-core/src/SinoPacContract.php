<?php

namespace VeryBuy\Payment\SinoPac;

interface SinoPacContract
{
    const REQUEST_VACCOUNT = 'https://ecapi.sinopac.com/WebAPI/Service.svc/CreateATMorIBonTrans';
    const REQUEST_VACCOUNT_TEST = 'https://sandbox.sinopac.com/WebAPI/Service.svc/CreateATMorIBonTrans';
    const REQUEST_QUERY_TRADE_STATUS = 'https://ecapi.sinopac.com/WebAPI/Service.svc/QueryTradeStatus';
    const REQUEST_QUERY_TRADE_STATUS_TEST = 'https://sandbox.sinopac.com/WebAPI/Service.svc/QueryTradeStatus';
    const PAYTYPE_ATM = 'A';
    const PAYTYPE_CREDITCARD = 'C';
    const PAYFLAG_ATM_ALL = 'A';
    const PAYFLAG_ATM_PAID = 'Y';
    const PAYFLAG_ATM_UNPAY = 'N';
    const PAYFLAG_CREDITCARD_ALL = 'A';
    const PAYFLAG_CREDITCARD_AUTHORIZE = 'Y';
    const PAYFLAG_CREDITCARD_UNAUTHORIZE = 'N';
    const RESPONSE_AUTOPUSH_REFUND = 'Y';
    const CLOSECASE_STATUS_SUCCESS = 'S';
    const CLOSECASE_STATUS_FAILED = 'F';
}
