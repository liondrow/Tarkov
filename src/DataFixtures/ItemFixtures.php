<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Item;
use App\Entity\ItemCategory;
use App\Entity\QuestBranch;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends BaseFixtures implements DependentFixtureInterface
{
	const COUNT = 10;

	protected function loadData(ObjectManager $em): void
	{
		$this->createMany(Item::class, self::COUNT, function (Item $item) {
			$item->setName($this->faker->word);
			$item->setEnabled($this->faker->boolean(80));
			$item->setBaraholshikPrice($this->faker->randomFloat(2, 10));
			$item->setPraporPrice($this->faker->randomFloat(2, 10));
			$item->setTerapevtPrice($this->faker->randomFloat(2, 10));
			$item->setCategory($this->getReference(ItemCategory::class . "_" . 0, ItemCategory::class));
		});
		$em->flush();
	}

	public function getDependencies(): array
	{
		return [ItemCategoryFixtures::class];
	}
}