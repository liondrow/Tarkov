<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestRepository::class)]
class Quest
{

	public function __toString(): string
	{
		return $this->getId() . ". " . $this->getName();
	}

	#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    private ?User $target = null;

    #[ORM\Column(nullable: true)]
    private ?float $reward = null;

    #[ORM\ManyToOne(inversedBy: 'quests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuestBranch $branch = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childQuests')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $childQuests;

    #[ORM\OneToMany(mappedBy: 'quest', targetEntity: QuestProgress::class, orphanRemoval: true)]
    private Collection $questProgress;

    public function __construct()
    {
        $this->childQuests = new ArrayCollection();
        $this->questProgress = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTarget(): ?User
    {
        return $this->target;
    }

    public function setTarget(?User $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function getReward(): ?float
    {
        return $this->reward;
    }

    public function setReward(?float $reward): static
    {
        $this->reward = $reward;

        return $this;
    }

    public function getBranch(): ?QuestBranch
    {
        return $this->branch;
    }

    public function setBranch(?QuestBranch $branch): static
    {
        $this->branch = $branch;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildQuests(): Collection
    {
        return $this->childQuests;
    }

    public function addChildQuest(self $childQuest): static
    {
        if (!$this->childQuests->contains($childQuest)) {
            $this->childQuests->add($childQuest);
            $childQuest->setParent($this);
        }

        return $this;
    }

    public function removeChildQuest(self $childQuest): static
    {
        if ($this->childQuests->removeElement($childQuest)) {
            // set the owning side to null (unless already changed)
            if ($childQuest->getParent() === $this) {
                $childQuest->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuestProgress>
     */
    public function getQuestProgress(): Collection
    {
        return $this->questProgress;
    }

    public function addQuestProgress(QuestProgress $questProgress): static
    {
        if (!$this->questProgress->contains($questProgress)) {
            $this->questProgress->add($questProgress);
            $questProgress->setQuest($this);
        }

        return $this;
    }

    public function removeQuestProgress(QuestProgress $questProgress): static
    {
        if ($this->questProgress->removeElement($questProgress)) {
            // set the owning side to null (unless already changed)
            if ($questProgress->getQuest() === $this) {
                $questProgress->setQuest(null);
            }
        }

        return $this;
    }
}
