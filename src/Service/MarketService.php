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
use App\Entity\User;
use App\Entity\Wallet;
use App\Enum\InvoiceType;
use App\Exception\GameException;
use App\Exception\NotFoundException;
use App\Model\MarketValidationDto;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MarketService
{

	public function __construct(private readonly EntityManagerInterface $entityManager)
	{
	}

	/**
	 * @throws NotFoundException
	 * @throws GameException
	 * @throws Exception
	 */
	public function makeOrder(Game $game, string $lotId, User $user): MarketValidationDto
	{
		$lot = $this->entityManager->getRepository(MarketItem::class)->findOneBy(['game' => $game, 'id' => $lotId, 'enabled' => true]);
		if (!$lot)
		{
			throw new NotFoundException("Лот не найден");
		}
		$lot->setEnabled(false);

		$marketInvoice = new MarketInvoice();
		$marketInvoice->setDate(new \DateTime());
		$marketInvoice->setBuyer($user);
		$marketInvoice->setLot($lot);
		$marketInvoice->setDelivered(false);

		$this->entityManager->beginTransaction();
		try
		{
			$buyerWallet = $this->entityManager->getRepository(Wallet::class)->findOneBy(['game' => $game, 'user' => $user]);
			if($buyerWallet->getValue() < $lot->getPrice()) {
				throw new GameException("Недостаточно средств на счете");
			}
			$newBuyerWallet = $buyerWallet->getValue() - $lot->getPrice();
			$buyerWallet->setValue($newBuyerWallet);

			$sellerWallet = $this->entityManager->getRepository(Wallet::class)->findOneBy(['game' => $game, 'user' => $lot->getSeller()]);
			$sellerWallet->setValue($sellerWallet->getValue() + $lot->getPrice());

			$invoiceJournal = new InvoiceJournal();
			$invoiceJournal->setType(InvoiceType::MARKET);
			$invoiceJournal->setSum($lot->getPrice());
			$invoiceJournal->setGame($game);
			$invoiceJournal->setUserFrom($user);
			$invoiceJournal->setUserTo($lot->getSeller());
			$invoiceJournal->setCreateAt(new \DateTimeImmutable());

			$this->entityManager->persist($marketInvoice);
			$this->entityManager->persist($buyerWallet);
			$this->entityManager->persist($sellerWallet);
			$this->entityManager->persist($lot);
			$this->entityManager->persist($invoiceJournal);
			$this->entityManager->flush();
			$this->entityManager->commit();

			$result = new MarketValidationDto();
			$result->setSuccess(true);
			$result->setBuyerWalletValue($newBuyerWallet);
			return $result;
		} catch (GameException $gameException) {
			$this->entityManager->rollback();
			throw new Exception($gameException->getMessage());
		} catch (Exception $exception) {
			$this->entityManager->rollback();
			throw new Exception("Возникла ошибка при покупке, попробуйте еще раз или обратитесь к организатору");
		}
	}

}