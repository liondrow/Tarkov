<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\InvoiceJournal;
use App\Entity\MarketInvoice;
use App\Entity\MarketItem;
use App\Entity\UserShelter;
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


	public function getSheltersForUser(Game $game, User $user): array
	{
		$shelters = [];
		$userShelters = $this->entityManager->getRepository(UserShelter::class)->getSheltersListByUserAndGame($game, $user);
		foreach($userShelters as $shelter) {
			$shelters[] = ShelterDto::newFromEntity($shelter);
		}
		return $shelters;
	}

}