<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends BaseFixtures
{

	const COUNT = 1;

	protected function loadData(ObjectManager $em): void
	{
		$this->createMany(Game::class, self::COUNT, function (Game $game) {
			$game->setName("Игра #1");
			$game->setEnabled(true);
			$game->setDate(new \DateTime());
			$game->setCity("Тихорецк");
			$game->setCreated(new \DateTime());
		});
		$em->flush();
	}
}