<?php
/*
 * Copyright (c) 2023.
 * This file is part of the Sentima application.
 * (c) Sentima - Ivan Sereda <liondrow2@yandex.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use App\Entity\Quest;

class QuestDto implements \JsonSerializable
{

	private int $id;
	private string $name;
	private int $reward;
	private string $description;
	private string $target;

	public static function newFromEntity(Quest $quest): static
	{
		$q = new static;
		$q->setId($quest->getId());
		$q->setName($quest->getName());
		$q->setDescription($quest->getDescription());
		$q->setReward($quest->getReward());
		$q->setTarget($quest->getTarget()->getTeamName());
		return $q;
	}


	public function jsonSerialize(): mixed
	{
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'reward' => $this->getReward(),
			'description' => $this->getDescription(),
			'target' => $this->getTarget()
		];
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getReward(): int
	{
		return $this->reward;
	}

	public function setReward(int $reward): void
	{
		$this->reward = $reward;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	public function getTarget(): string
	{
		return $this->target;
	}

	public function setTarget(string $target): void
	{
		$this->target = $target;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}


}