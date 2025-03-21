<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\QuestBranch;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixtures implements DependentFixtureInterface
{
	public function __construct(private readonly UserPasswordHasherInterface $hasher) {}
	const COUNT = 3;

	protected function loadData(ObjectManager $em): void
	{
		$this->createMany(User::class, self::COUNT, function (User $user) {
			$user->setUsername($this->faker->userName);
			$user->setRoles(['ROLE_USER']);
			$user->setPassword($this->hasher->hashPassword($user, 'password'));
			$user->setCreatedAt(new \DateTimeImmutable());
			$user->setEnabled(true);
			$user->setNickname($this->faker->userName);
			$user->setAirsoftTeam($this->faker->company);
			$user->setIsPmc(true);
			$user->setSeller(false);
			$user->addGame($this->getReference(Game::class . "_" . 0, Game::class));
			$user->setQuestBranch($this->getReference(QuestBranch::class . "_" . $this->faker->numberBetween(0, QuestBranchFixtures::COUNT - 1),QuestBranch::class));
		});
		$em->flush();
	}

	public function getDependencies(): array
	{
		return [GameFixtures::class, QuestBranchFixtures::class];
	}
}