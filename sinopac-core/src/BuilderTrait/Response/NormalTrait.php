<?php

namespace VeryBuy\Payment\SinoPac\BuilderTrait\Response;

trait NormalTrait
{
	public function getAmount(): int
	{
		return ($this->parsed->Amount / 100);
	}

	public function getId(): string
	{
		return $this->parsed->TSNO;
	}

	public function getOrderNumber(): string
	{
		return $this->parsed->OrderNO;
	}
}
