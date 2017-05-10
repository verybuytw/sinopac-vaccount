<?php

namespace VeryBuy\Payment\SinoPac\VirtualAccount;

use Carbon\Carbon;
use VeryBuy\Payment\SinoPac\CurrencyContract;
use VeryBuy\Payment\SinoPac\Exceptions\InvalidArgumentException;
use VeryBuy\Payment\SinoPac\RequestContract;

class VirtualAccount extends RequestContract
{
    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->options, [
            'CurrencyID' => CurrencyContract::TWD,
            'PayType' => 'A'
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
        $carbon = Carbon::parse(date('Y-m-d'))
            ->addDays(31)
            ->subSecond();

        $expire = Carbon::parse($this->options['ExpireDate']);

        if ($expire->gte($carbon)) {
            throw new InvalidArgumentException(strtr('Expire date({expire}) can not greater then {limit}.', [
                '{expire}' => $expire->format('Y-m-d H:i:s'),
                '{limit}' => $carbon->format('Y-m-d H:i:s'),
            ]));
        }

        return $this;
    }
}
