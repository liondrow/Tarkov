<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\TeamShelter;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamShelter>
 *
 * @method TeamShelter|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamShelter|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamShelter[]    findAll()
 * @method TeamShelter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamShelterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamShelter::class);
    }

	public function clearTable(): void
	{
		$this->createQueryBuilder('t')
			->delete()
			->getQuery()
			->getResult();
	}

	public function getSheltersListByTeamAndGame(Game $game, User $team)
	{
		return $this->createQueryBuilder('t')
			->join('t.shelter', 's')
			->andWhere('t.game = :game')
			->andWhere('t.team = :team')
			->andWhere('s.enabled = :enabled')
			->setParameter('game', $game)
			->setParameter('team', $team)
			->setParameter('enabled', true)
			->getQuery()
			->getResult();
	}
}
