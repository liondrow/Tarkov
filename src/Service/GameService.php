<?php
/*
 * Copyright (c) 2023.
 * This file is part of the Sentima application.
 * (c) Sentima - Ivan Sereda <liondrow2@yandex.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Game;
use App\Exception\GameNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{

	public function __construct(private readonly EntityManagerInterface $entityManager)
	{
	}

	/**
	 * @throws GameNotFoundException
	 */
	public function getCurrentGame(): ?Game
	{
		$activeGame = $this->entityManager->getRepository(Game::class)->findOneBy(['enabled' => true]);
		if(empty($activeGame)) {
			throw new GameNotFoundException("Нет активной игры");
		}
		return $activeGame;
	}

}