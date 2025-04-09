<?php

namespace App\Model;

use App\Entity\Item;

class ItemDto implements \JsonSerializable
{
	private int $id;
	private string $name;
	private float $praporPrice;
	private float $terapevtPrice;
	private float $baraholshikPrice;

	public function jsonSerialize(): array
	{
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'praporPrice'=> $this->getPraporPrice(),
			'terapevtPrice' => $this->getTerapevtPrice(),
			'baraholshikPrice' => $this->getBaraholshikPrice()
 		];
	}

	public static function newFromEntity(Item $item): self
	{
		$r = new static;
		$r->setId($item->getId());
		$r->setName($item->getName());
		$r->setPraporPrice($item->getPraporPrice());
		$r->setTerapevtPrice($item->getTerapevtPrice());
		$r->setBaraholshikPrice($item->getBaraholshikPrice());
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

	public function getPraporPrice(): float
	{
		return $this->praporPrice;
	}

	public function setPraporPrice(float $praporPrice): void
	{
		$this->praporPrice = $praporPrice;
	}

	public function getTerapevtPrice(): float
	{
		return $this->terapevtPrice;
	}

	public function setTerapevtPrice(float $terapevtPrice): void
	{
		$this->terapevtPrice = $terapevtPrice;
	}

	public function getBaraholshikPrice(): float
	{
		return $this->baraholshikPrice;
	}

	public function setBaraholshikPrice(float $baraholshikPrice): void
	{
		$this->baraholshikPrice = $baraholshikPrice;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}


}