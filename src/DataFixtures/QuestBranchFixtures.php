<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\QuestBranch;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestBranchFixtures extends BaseFixtures implements DependentFixtureInterface
{
	const COUNT = 3;

	protected function loadData(ObjectManager $em): void
	{
		$this->createMany(QuestBranch::class, self::COUNT, function (QuestBranch $questBranch) {
			$questBranch->setName("Ветка квестов №" . $this->faker->numberBetween(1, self::COUNT));
			$questBranch->setEnabled(true);
			$questBranch->setGame($this->getReference(Game::class . "_" . 0, Game::class));
		});
		$em->flush();
	}

	public function getDependencies(): array
	{
		return [GameFixtures::class];
	}
}