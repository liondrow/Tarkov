<?php

namespace App\Entity;

use App\Enum\InvoiceType;
use App\Repository\InvoiceJournalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceJournalRepository::class)]
class InvoiceJournal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $teamFrom = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $teamTo = null;

    #[ORM\Column(nullable: true)]
    private ?float $sum = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $request = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(length: 255, nullable: true, enumType: InvoiceType::class)]
    private ?InvoiceType $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getTeamFrom(): ?User
    {
        return $this->teamFrom;
    }

    public function setTeamFrom(?User $teamFrom): static
    {
        $this->teamFrom = $teamFrom;

        return $this;
    }

    public function getTeamTo(): ?User
    {
        return $this->teamTo;
    }

    public function setTeamTo(?User $teamTo): static
    {
        $this->teamTo = $teamTo;

        return $this;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(?float $sum): static
    {
        $this->sum = $sum;

        return $this;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(?string $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

	public function getType(): ?InvoiceType
	{
		return $this->type;
	}

	public function setType(?InvoiceType $type): void
	{
		$this->type = $type;
	}
}
