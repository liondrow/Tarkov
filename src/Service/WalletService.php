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
use App\Entity\User;
use App\Entity\Wallet;
use App\Exception\InvalidWalletSumException;
use App\Exception\NotFoundException;
use App\Model\InvoiceHistoryDto;
use Doctrine\ORM\EntityManagerInterface;

class WalletService
{

	const TYPE_INCOMING = "INCOMING";
	const TYPE_OUTGOING = "OUTGOING";

	public function __construct(private readonly EntityManagerInterface $entityManager)
	{
	}

	public function getInvoiceHistoryForGame(Game $game, User $team): array
	{
		$resHistory = [];
		$outgoingInvoices = $this->entityManager->getRepository(InvoiceJournal::class)->findBy(['game' => $game, 'teamFrom' => $team]);
		if(!empty($outgoingInvoices))
		{
			foreach ($outgoingInvoices as $outgoingInvoice)
			{
				$resHistory[$outgoingInvoice->getId()] = new InvoiceHistoryDto(
					$outgoingInvoice->getTeamTo()->getUserIdentifier(),
					$outgoingInvoice->getTeamTo()->getTeamName(),
					$outgoingInvoice->getSum(),
					self::TYPE_OUTGOING
				);
			}
		}
		$incomingInvoices = $this->entityManager->getRepository(InvoiceJournal::class)->findBy(['game' => $game, 'teamTo' => $team]);
		if(!empty($incomingInvoices))
		{
			foreach ($incomingInvoices as $incomingInvoice)
			{
				$resHistory[$incomingInvoice->getId()] = new InvoiceHistoryDto(
					$incomingInvoice->getTeamFrom()->getUserIdentifier(),
					$incomingInvoice->getTeamFrom()->getTeamName(),
					$incomingInvoice->getSum(),
					self::TYPE_INCOMING
				);
			}
		}
		krsort($resHistory);
		return array_values($resHistory);
	}


	/**
	 * @throws InvalidWalletSumException
	 * @throws NotFoundException
	 */
	public function sendInvoice(
		Game $game,
		User $userFrom,
		string $userToId,
		float $sum
	): ?float
	{
		$wallet = $userFrom->getWallets()->filter(function (Wallet $wallet) use ($game) {
			return $wallet->getGame() === $game;
		})->toArray();
		/** @var ?Wallet $resWallet */
		$resWallet = (!empty($wallet) && is_array($wallet)) ? current($wallet) : $wallet;
		if(empty($resWallet)) {
			throw new NotFoundException("Ошибка! Кошелек не активен.");
		}

		$userTo = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $userToId]);
		if(empty($userTo)) {
			throw new NotFoundException("Команда получателя не найдена");
		}
		$userToWallet = $userTo->getWallets()->filter(function (Wallet $wallet) use ($game) {
			return $wallet->getGame() === $game;
		})->toArray();
		/** @var ?Wallet $resUserToWallet */
		$resUserToWallet = (!empty($userToWallet) && is_array($userToWallet)) ? current($userToWallet) : $userToWallet;

		if($resWallet->getValue() < $sum) {
			throw new InvalidWalletSumException("Недостаточно средств для перевода");
		}

		$resUserToWallet->setValue((float)$resUserToWallet->getValue() + $sum);
		$resWallet->setValue((float)$resWallet->getValue() - $sum);

		$this->saveInvoiceToJournal($game, $userFrom, $userTo, $sum);

		$this->entityManager->persist($resUserToWallet);
		$this->entityManager->persist($resWallet);
		$this->entityManager->flush();
		return $resWallet->getValue();
	}

	private function saveInvoiceToJournal(Game $game, User $teamFrom, User $teamTo, float $sum): void
	{
		$journalInvoice = new InvoiceJournal();
		$journalInvoice->setGame($game);
		$journalInvoice->setTeamTo($teamTo);
		$journalInvoice->setTeamFrom($teamFrom);
		$journalInvoice->setSum($sum);
		$journalInvoice->setCreateAt(new \DateTimeImmutable());
		$this->entityManager->persist($journalInvoice);
		$this->entityManager->flush();
	}

}