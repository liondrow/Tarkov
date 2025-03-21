<?php
/*
 * Copyright (c) 2023.
 * This file is part of the Sentima application.
 * (c) Sentima - Ivan Sereda <liondrow2@yandex.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

class InvoiceHistoryDto implements \JsonSerializable
{

	public function __construct(
		private string $userId,
		private string $user,
		private float $sum,
		private string $type
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			'userId' => $this->getUserId(),
			'user' => $this->getUser(),
			'sum' => $this->getSum(),
			'type' => $this->getType()
		];
	}

	public function getUser(): string
	{
		return $this->user;
	}

	public function setUser(string $user): void
	{
		$this->user = $user;
	}

	public function getSum(): float
	{
		return $this->sum;
	}

	public function setSum(float $sum): void
	{
		$this->sum = $sum;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function setType(string $type): void
	{
		$this->type = $type;
	}

	public function getUserId(): string
	{
		return $this->userId;
	}

	public function setUserId(string $userId): void
	{
		$this->userId = $userId;
	}


}