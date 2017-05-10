<?php

namespace VeryBuy\Payment\SinoPac;

interface SinoPacContract
{
    const REQUEST_VACCOUNT = 'https://ecapi.sinopac.com/WebAPI/Service.svc/CreateATMorIBonTrans';
    const REQUEST_VACCOUNT_TEST = 'https://sandbox.sinopac.com/WebAPI/Service.svc/CreateATMorIBonTrans';
}
