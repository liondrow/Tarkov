<?php

namespace App\Model;

use App\Entity\MapPoint;

class MapPointDto implements \JsonSerializable
{
	private int $id;
	private string $name;
	private string $latitude;
	private string $longitude;
	private ?string $clip;

	public function jsonSerialize(): array
	{
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'latitude'=> $this->getLatitude(),
			'longitude' => $this->getLongitude(),
			'clipRect' => $this->getClip(),
 		];
	}

	public static function newFromEntity(MapPoint $point): self
	{
		$r = new static;
		$r->setId($point->getId());
		$r->setName($point->getName());
		$r->setLatitude($point->getLatitude());
		$r->setLongitude($point->getLongitude());
		$r->setClip($point->getClipRect());
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

	public function getLatitude(): string
	{
		return $this->latitude;
	}

	public function setLatitude(string $latitude): void
	{
		$this->latitude = $latitude;
	}

	public function getLongitude(): string
	{
		return $this->longitude;
	}

	public function setLongitude(string $longitude): void
	{
		$this->longitude = $longitude;
	}

	public function getClip(): ?string
	{
		return $this->clip;
	}

	public function setClip(?string $clip): void
	{
		$this->clip = $clip;
	}




}