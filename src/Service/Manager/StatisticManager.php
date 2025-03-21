<?php

namespace App\Service\Manager;

use App\Entity\QuestProgress;
use App\Entity\User;
use App\Enum\QuestStatus;
use Doctrine\ORM\EntityManagerInterface;

class StatisticManager
{

	public function __construct(readonly public EntityManagerInterface $em)
	{
	}

	public function getTotalPlayers(): mixed
	{
		return $this->em->getRepository(User::class)
		                ->createQueryBuilder('p')
		                ->select('COUNT(p.id)')
		                ->getQuery()
		                ->getSingleScalarResult();
	}

	public function getFinishedQuestCount(): mixed
	{
		return $this->em->getRepository(QuestProgress::class)
		                ->createQueryBuilder('q')
		                ->select('COUNT(q.id)')
		                ->andWhere('q.status = :status')
		                ->setParameter('status', QuestStatus::FINISHED)
		                ->getQuery()
		                ->getSingleScalarResult();
	}

	public function getMostUsersQuestCount(): mixed
	{
		return $this->em->getRepository(User::class)
		                ->createQueryBuilder('u')
		                ->select('u.id, u.nickname, COUNT(qp.id) AS finishedQuests')
		                ->leftJoin('u.questProgress', 'qp')
		                ->andWhere('qp.status = :status')
		                ->setParameter('status', 'FINISHED')
		                ->groupBy('u.id')
		                ->orderBy('finishedQuests', 'DESC')
		                ->setMaxResults(5)
		                ->getQuery()
		                ->getScalarResult();
	}

	public function getMostReachableUsers(): array
	{
		$resReachableUsersValue = [];
		$mostReachableUsers = $this->em->getRepository(User::class)
		                               ->createQueryBuilder('u')
		                               ->select('u')
		                               ->join('u.wallets', 'w')
		                               ->andWhere('u.seller = false')
		                               ->orderBy('w.value', 'DESC')
		                               ->setMaxResults(5)
		                               ->getQuery()
		                               ->getResult();

		/** @var User $mostReachableUser */
		foreach ($mostReachableUsers as $mostReachableUser)
		{
			$resReachableUsersValue[$mostReachableUser->getNickname()] = $mostReachableUser->getWallets()->first()->getValue();
		}
		return $resReachableUsersValue;
	}

	public function getMostReachableSellers(): array
	{
		$resReachableSellersValue = [];
		$mostReachableSellers = $this->em->getRepository(User::class)
		                                 ->createQueryBuilder('u')
		                                 ->select('u')
		                                 ->join('u.wallets', 'w')
		                                 ->andWhere('u.seller = true')
		                                 ->orderBy('w.value', 'DESC')
		                                 ->setMaxResults(5)
		                                 ->getQuery()
		                                 ->getResult();

		/** @var User $mostReachableSeller */
		foreach ($mostReachableSellers as $mostReachableSeller)
		{
			$resReachableSellersValue[$mostReachableSeller->getNickname()] = $mostReachableSeller->getWallets()->first()->getValue();
		}
		return $resReachableSellersValue;
	}
}