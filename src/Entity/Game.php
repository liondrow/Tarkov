<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{

	public function __toString(): string
                              	{
                              		return $this->getName();
                              	}

	#[ORM\Id]
                                  #[ORM\GeneratedValue]
                                  #[ORM\Column]
                                  private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'game')]
    private Collection $users;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mapX = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mapY = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $polygon = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: QuestBranch::class, orphanRemoval: true)]
    private Collection $questBranches;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: MarketItem::class)]
    private Collection $marketItems;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->questBranches = new ArrayCollection();
        $this->marketItems = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addGame($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeGame($this);
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getMapX(): ?string
    {
        return $this->mapX;
    }

    public function setMapX(?string $mapX): static
    {
        $this->mapX = $mapX;

        return $this;
    }

    public function getMapY(): ?string
    {
        return $this->mapY;
    }

    public function setMapY(?string $mapY): static
    {
        $this->mapY = $mapY;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getPolygon(): ?string
    {
        return $this->polygon;
    }

    public function setPolygon(?string $polygon): static
    {
        $this->polygon = $polygon;

        return $this;
    }

    /**
     * @return Collection<int, QuestBranch>
     */
    public function getQuestBranches(): Collection
    {
        return $this->questBranches;
    }

    public function addQuestBranch(QuestBranch $questBranch): static
    {
        if (!$this->questBranches->contains($questBranch)) {
            $this->questBranches->add($questBranch);
            $questBranch->setGame($this);
        }

        return $this;
    }

    public function removeQuestBranch(QuestBranch $questBranch): static
    {
        if ($this->questBranches->removeElement($questBranch)) {
            // set the owning side to null (unless already changed)
            if ($questBranch->getGame() === $this) {
                $questBranch->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MarketItem>
     */
    public function getMarketItems(): Collection
    {
        return $this->marketItems;
    }

    public function addMarketItem(MarketItem $marketItem): static
    {
        if (!$this->marketItems->contains($marketItem)) {
            $this->marketItems->add($marketItem);
            $marketItem->setGame($this);
        }

        return $this;
    }

    public function removeMarketItem(MarketItem $marketItem): static
    {
        if ($this->marketItems->removeElement($marketItem)) {
            // set the owning side to null (unless already changed)
            if ($marketItem->getGame() === $this) {
                $marketItem->setGame(null);
            }
        }

        return $this;
    }
}
