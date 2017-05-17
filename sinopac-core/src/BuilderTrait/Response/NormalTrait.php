<?php

namespace VeryBuy\Payment\SinoPac\BuilderTrait\Response;

trait NormalTrait
{
	/**
	 * @return int
	 */
	public function getAmount(): int
	{
		return ($this->parsed->Amount / 100);
	}

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->parsed->TSNO;
	}

	/**
	 * @return string
	 */
	public function getOrderNumber(): string
	{
		return $this->parsed->OrderNO;
	}
}
