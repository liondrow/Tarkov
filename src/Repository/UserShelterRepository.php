<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\UserShelter;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserShelter>
 *
 * @method UserShelter|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserShelter|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserShelter[]    findAll()
 * @method UserShelter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserShelterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserShelter::class);
    }

	public function clearTable(): void
	{
		$this->createQueryBuilder('t')
			->delete()
			->getQuery()
			->getResult();
	}

	public function getSheltersListByUserAndGame(Game $game, User $user)
	{
		return $this->createQueryBuilder('t')
			->join('t.shelter', 's')
			->andWhere('t.game = :game')
			->andWhere('t.user = :user')
			->andWhere('s.enabled = :enabled')
			->setParameter('game', $game)
			->setParameter('user', $user)
			->setParameter('enabled', true)
			->getQuery()
			->getResult();
	}
}
