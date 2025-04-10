<?php

namespace App\Entity;

use App\Repository\MapPointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapPointRepository::class)]
class MapPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255)]
    private ?string $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isStash = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $clipRect = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function isStash(): ?bool
    {
        return $this->isStash;
    }

    public function setIsStash(?bool $isStash): static
    {
        $this->isStash = $isStash;

        return $this;
    }

	public function getClipRect(): ?string
	{
		return $this->clipRect;
	}

	public function setClipRect(?string $clipRect): void
	{
		$this->clipRect = $clipRect;
	}


}
