<?php
/*
 * Copyright (c) 2023.
 * This file is part of the Sentima application.
 * (c) Sentima - Ivan Sereda <liondrow2@yandex.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

class MarketValidationDto implements \JsonSerializable
{
	private float $buyerWalletValue = 0.0;
	private bool $success = false;


	public function jsonSerialize(): array
	{
		return [
			'buyerWalletValue' => $this->getBuyerWalletValue(),
			'status' => $this->isSuccess()
		];
	}

	public function getBuyerWalletValue(): float
	{
		return $this->buyerWalletValue;
	}

	public function setBuyerWalletValue(float $buyerWalletValue): void
	{
		$this->buyerWalletValue = $buyerWalletValue;
	}

	public function isSuccess(): bool
	{
		return $this->success;
	}

	public function setSuccess(bool $success): void
	{
		$this->success = $success;
	}
}