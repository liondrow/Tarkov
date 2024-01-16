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
		private string $teamId,
		private string $team,
		private float $sum,
		private string $type
	)
	{
	}

	public function jsonSerialize(): mixed
	{
		return [
			'teamId' => $this->getTeamId(),
			'team' => $this->getTeam(),
			'sum' => $this->getSum(),
			'type' => $this->getType()
		];
	}

	public function getTeam(): string
	{
		return $this->team;
	}

	public function setTeam(string $team): void
	{
		$this->team = $team;
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

	public function getTeamId(): string
	{
		return $this->teamId;
	}

	public function setTeamId(string $teamId): void
	{
		$this->teamId = $teamId;
	}


}