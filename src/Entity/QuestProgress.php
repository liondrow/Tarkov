<?php

namespace App\Entity;

use App\Enum\QuestStatus;
use App\Repository\QuestProgressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestProgressRepository::class)]
class QuestProgress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'questProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quest $quest = null;

    #[ORM\ManyToOne(inversedBy: 'questProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $team = null;

    #[ORM\Column(length: 255, nullable: false, enumType: QuestStatus::class)]
    private ?QuestStatus $status = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuest(): ?Quest
    {
        return $this->quest;
    }

    public function setQuest(?Quest $quest): static
    {
        $this->quest = $quest;

        return $this;
    }

    public function getTeam(): ?User
    {
        return $this->team;
    }

    public function setTeam(?User $team): static
    {
        $this->team = $team;

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

	public function getStatus(): ?QuestStatus
	{
		return $this->status;
	}

	public function setStatus(?QuestStatus $status): static
	{
		$this->status = $status;

		return $this;
	}
}
