<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Item;
use App\Entity\ItemCategory;
use App\Entity\QuestBranch;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemCategoryFixtures extends BaseFixtures
{
	const COUNT = 4;

	protected function loadData(ObjectManager $em): void
	{
		$this->createMany(ItemCategory::class, self::COUNT, function (ItemCategory $category) {
			$category->setName($this->faker->word);
			$category->setEnabled($this->faker->boolean(90));
		});
		$em->flush();
	}
}