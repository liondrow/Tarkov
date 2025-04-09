<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    #[ORM\Column(nullable: true)]
    private ?float $praporPrice = null;

    #[ORM\Column(nullable: true)]
    private ?float $terapevtPrice = null;

    #[ORM\Column(nullable: true)]
    private ?float $baraholshikPrice = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ItemCategory $category = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getPraporPrice(): ?float
    {
        return $this->praporPrice;
    }

    public function setPraporPrice(?float $praporPrice): static
    {
        $this->praporPrice = $praporPrice;

        return $this;
    }

    public function getTerapevtPrice(): ?float
    {
        return $this->terapevtPrice;
    }

    public function setTerapevtPrice(?float $terapevtPrice): static
    {
        $this->terapevtPrice = $terapevtPrice;

        return $this;
    }

    public function getBaraholshikPrice(): ?float
    {
        return $this->baraholshikPrice;
    }

    public function setBaraholshikPrice(?float $baraholshikPrice): static
    {
        $this->baraholshikPrice = $baraholshikPrice;

        return $this;
    }

    public function getCategory(): ?ItemCategory
    {
        return $this->category;
    }

    public function setCategory(?ItemCategory $category): static
    {
        $this->category = $category;

        return $this;
    }
}
