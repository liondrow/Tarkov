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
use App\Entity\InvoiceJournal;
use App\Entity\MarketInvoice;
use App\Entity\MarketItem;
use App\Entity\TeamShelter;
use App\Entity\User;
use App\Entity\Wallet;
use App\Enum\InvoiceType;
use App\Exception\GameException;
use App\Exception\NotFoundException;
use App\Model\MarketValidationDto;
use App\Model\ShelterDto;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ShelterService
{

	public function __construct(private readonly EntityManagerInterface $entityManager)
	{
	}


	public function getSheltersForTeam(Game $game, User $user): array
	{
		$shelters = [];
		$teamShelters = $this->entityManager->getRepository(TeamShelter::class)->getSheltersListByTeamAndGame($game, $user);
		foreach($teamShelters as $shelter) {
			$shelters[] = ShelterDto::newFromEntity($shelter);
		}
		return $shelters;
	}

}