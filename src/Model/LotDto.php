<?php
/*
 * Copyright (c) 2023.
 * This file is part of the Sentima application.
 * (c) Sentima - Ivan Sereda <liondrow2@yandex.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use App\Entity\MarketItem;

class LotDto implements \JsonSerializable
{
	private int $id;
	private string $item;
	private float $price;
	private string $seller;
	private \DateTimeInterface $date;

	public function jsonSerialize(): array
	{
		return [
			'id' => $this->getId(),
			'item' => $this->getItem(),
			'price'=> $this->getPrice(),
			'seller' => $this->getSeller(),
			'date' => $this->getDate()
 		];
	}

	public static function newFromEntity(MarketItem $item): self
	{
		$r = new static;
		$r->setId($item->getId());
		$r->setItem($item->getItem());
		$r->setPrice($item->getPrice());
		$r->setSeller($item->getSeller()->getTeamName());
		$r->setDate($item->getCreated());
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

	public function getItem(): string
	{
		return $this->item;
	}

	public function setItem(string $item): void
	{
		$this->item = $item;
	}

	public function getPrice(): float
	{
		return $this->price;
	}

	public function setPrice(float $price): void
	{
		$this->price = $price;
	}

	public function getSeller(): string
	{
		return $this->seller;
	}

	public function setSeller(string $seller): void
	{
		$this->seller = $seller;
	}

	public function getDate(): \DateTimeInterface
	{
		return $this->date;
	}

	public function setDate(\DateTimeInterface $date): void
	{
		$this->date = $date;
	}


}