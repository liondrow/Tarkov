<?php

namespace App\Model;

use App\Entity\UserShelter;

class ShelterDto implements \JsonSerializable
{
	private int $id;
	private string $name;
	private string $description;
	private string $bonus;
	private bool $status;

	public function jsonSerialize(): array
	{
		return [
			'id' => $this->getId(),
			'shelter' => $this->getName(),
			'description' => $this->getDescription(),
			'bonus' => $this->getBonus(),
			'status' => $this->isStatus()
		];
	}

	public static function newFromEntity(UserShelter $shelter): self
	{
		$r = new static;
		$r->setId($shelter->getId());
		$r->setName($shelter->getShelter()->getName());
		$r->setDescription($shelter->getShelter()->getDescription());
		$r->setBonus($shelter->getShelter()->getBonus());
		$r->setStatus($shelter->isEnabled());
		return $r;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	public function getBonus(): string
	{
		return $this->bonus;
	}

	public function setBonus(string $bonus): void
	{
		$this->bonus = $bonus;
	}

	public function isStatus(): bool
	{
		return $this->status;
	}

	public function setStatus(bool $status): void
	{
		$this->status = $status;
	}



}