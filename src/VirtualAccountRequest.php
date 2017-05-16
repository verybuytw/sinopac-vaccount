<?php

namespace VeryBuy\Payment\SinoPac\VirtualAccount;

use Carbon\Carbon;
use VeryBuy\Payment\SinoPac\CurrencyContract;
use VeryBuy\Payment\SinoPac\Exceptions\InvalidArgumentException;
use VeryBuy\Payment\SinoPac\Requests\RequestContract;
use VeryBuy\Payment\SinoPac\SinoPacContract;

class VirtualAccountRequest extends RequestContract
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
            'Amount' => 000, // 只能 <= 30,000.00
            'CurrencyID' => CurrencyContract::TWD,
            'ExpireDate' => date('Ymd', strtotime('+30 days')), // 設至日期需 <= d+30
            'PayType' => SinoPacContract::PAYTYPE_ATM,
            'PrdtName' => null, // 收款名稱只能中英文不能特殊符號最大60字元
            'Memo' => null,
            'PayerName' => null,
            'PayerMobile' => null,
            'PayerAddress' => null,
            'PayerEmail' => null,
            'ReceiverName' => null,
            'ReceiverMobile' => null,
            'ReceiverAddress' => null,
            'ReceiverEmail' => null,
            'Param1' => null,
            'Param2' => null,
            'Param3' => null,
        ]);
    }

    /**
     * @return string
     */
    public function getXmlHeader(): string
    {
        return '<ATMOrIBonClientRequest xmlns="http://schemas.datacontract.org/2004/07/SinoPacWebAPI.Contract" />';
    }

    /**
     * @return self
     */
    public function validate(): self
    {
        return $this
            ->validFieldExists()
            ->validAmount()
            ->validExpireDate();
    }

    /**
     * @return self|InvalidArgumentException
     */
    protected function validFieldExists(): self
    {
        foreach (['Amount', 'ExpireDate'] as $field) {
            if (!array_key_exists($field, $this->options)) {
                throw new InvalidArgumentException(strtr('{field} is not exists.', [
                    '{field}' => $field
                ]));
            }
        }

        return $this;
    }

    /**
     * @return self|InvalidArgumentException
     */
    protected function validAmount(): self
    {
        $amountLimit = 30000 * 100;

        if ($this->options['Amount'] > $amountLimit or $this->options['Amount'] <= 0) {
            throw new InvalidArgumentException('Virtual account amount only can set 1 ~ 30,000.00.');
        }

        return $this;
    }

    /**
     * @return self|InvalidArgumentException
     */
    protected function validExpireDate(): self
    {
        $limitAt = Carbon::parse(date('Y-m-d'))
            ->addDays(31)
            ->subSecond();

        $expireAt = Carbon::parse($this->options['ExpireDate']);

        if ($expireAt->gte($limitAt)) {
            throw new InvalidArgumentException(strtr('Expire date({expire}) can not greater then {limit}.', [
                '{expire}' => $expireAt->format('Y-m-d H:i:s'),
                '{limit}' => $limitAt->format('Y-m-d H:i:s'),
            ]));
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseClass(): string
    {
        return VirtualAccountResponse::class;
    }
}
