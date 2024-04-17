<?php
namespace App\Tests;

use App\Entity\Game;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{

	public function testGetCurrentGame()
	{
		$game = new Game();
		$game->setEnabled(true);
		$game->setName("test");

		$gameRepo = $this->createMock(EntityRepository::class);
		$gameRepo->expects($this->any())
			->method('find')
			->willReturn($game);
	}
}
