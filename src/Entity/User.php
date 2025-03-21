<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

	public function __toString(): string
	{
		return "(" . $this->getUserIdentifier() . ") " . $this->getNickname();
	}

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 180, unique: true)]
	private ?string $username = null;

	#[ORM\Column]
	private array $roles = [];

	/**
	 * @var ?string The hashed password
	 */
	#[ORM\Column]
	private ?string $password = null;

	#[ORM\Column(length: 255)]
	private string $nickname = '';

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $airsoftTeam = null;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $createdAt = null;

	#[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'users')]
	private Collection $game;

	#[ORM\OneToMany(mappedBy: 'user', targetEntity: Wallet::class, orphanRemoval: true)]
	private Collection $wallets;

	#[ORM\Column(nullable: true)]
	private ?bool $enabled = null;

	#[ORM\OneToMany(mappedBy: 'user', targetEntity: QuestProgress::class, orphanRemoval: true)]
	private Collection $questProgress;

	#[ORM\Column(nullable: true)]
	private ?bool $seller = null;

	#[ORM\ManyToOne]
	private ?QuestBranch $questBranch = null;

	#[ORM\Column(nullable: true)]
	private ?bool $isAuctioner = false;

	#[ORM\OneToMany(mappedBy: 'user', targetEntity: UserShelter::class, orphanRemoval: true)]
	private Collection $userShelters;

	#[ORM\Column(nullable: true)]
	private ?bool $isPmc = false;

	public function __construct()
	{
		$this->game = new ArrayCollection();
		$this->wallets = new ArrayCollection();
		$this->questProgress = new ArrayCollection();
		$this->userShelters = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setUsername(string $username): static
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
	{
		return (string)$this->username;
	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';

		return array_unique($roles);
	}

	public function setRoles(array $roles): static
	{
		$this->roles = $roles;

		return $this;
	}

	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): static
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials(): void
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}

	public function getAirsoftTeam(): ?string
	{
		return $this->airsoftTeam;
	}

	public function setAirsoftTeam(?string $airsoftTeam): static
	{
		$this->airsoftTeam = $airsoftTeam;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?\DateTimeImmutable $createdAt): static
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * @return Collection<int, Game>
	 */
	public function getGame(): Collection
	{
		return $this->game;
	}

	public function addGame(Game $game): static
	{
		if (!$this->game->contains($game))
		{
			$this->game->add($game);
		}

		return $this;
	}

	public function removeGame(Game $game): static
	{
		$this->game->removeElement($game);

		return $this;
	}

	/**
	 * @return Collection<int, Wallet>
	 */
	public function getWallets(): Collection
	{
		return $this->wallets;
	}

	public function addWallet(Wallet $wallet): static
	{
		if (!$this->wallets->contains($wallet))
		{
			$this->wallets->add($wallet);
			$wallet->setUser($this);
		}

		return $this;
	}

	public function removeWallet(Wallet $wallet): static
	{
		if ($this->wallets->removeElement($wallet))
		{
			// set the owning side to null (unless already changed)
			if ($wallet->getUser() === $this)
			{
				$wallet->setUser(null);
			}
		}

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

	/**
	 * @return Collection<int, QuestProgress>
	 */
	public function getQuestProgress(): Collection
	{
		return $this->questProgress;
	}

	public function addQuestProgress(QuestProgress $questProgress): static
	{
		if (!$this->questProgress->contains($questProgress))
		{
			$this->questProgress->add($questProgress);
			$questProgress->setUser($this);
		}

		return $this;
	}

	public function removeQuestProgress(QuestProgress $questProgress): static
	{
		if ($this->questProgress->removeElement($questProgress))
		{
			// set the owning side to null (unless already changed)
			if ($questProgress->getUser() === $this)
			{
				$questProgress->setUser(null);
			}
		}

		return $this;
	}

	public function isSeller(): ?bool
	{
		return $this->seller;
	}

	public function setSeller(?bool $seller): static
	{
		$this->seller = $seller;

		return $this;
	}

	public function getQuestBranch(): ?QuestBranch
	{
		return $this->questBranch;
	}

	public function setQuestBranch(?QuestBranch $questBranch): static
	{
		$this->questBranch = $questBranch;

		return $this;
	}

	public function isIsAuctioner(): ?bool
	{
		return $this->isAuctioner;
	}

	public function setIsAuctioner(?bool $isAuctioner): static
	{
		$this->isAuctioner = $isAuctioner;

		return $this;
	}

	/**
	 * @return Collection<int, UserShelter>
	 */
	public function getUserShelters(): Collection
	{
		return $this->userShelters;
	}

	public function addUserShelter(UserShelter $userShelter): static
	{
		if (!$this->userShelters->contains($userShelter))
		{
			$this->userShelters->add($userShelter);
			$userShelter->setUser($this);
		}

		return $this;
	}

	public function removeUserShelter(UserShelter $userShelter): static
	{
		if ($this->userShelters->removeElement($userShelter))
		{
			// set the owning side to null (unless already changed)
			if ($userShelter->getUser() === $this)
			{
				$userShelter->setUser(null);
			}
		}

		return $this;
	}

	public function isIsPmc(): ?bool
	{
		return $this->isPmc;
	}

	public function setIsPmc(?bool $isPmc): static
	{
		$this->isPmc = $isPmc;

		return $this;
	}

	public function getNickname(): string
	{
		return $this->nickname;
	}

	public function setNickname(string $nickname): void
	{
		$this->nickname = $nickname;
	}
}
