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
			->andWhere('t.game = :game')
			->andWhere('t.team = :team')
			->setParameter('game', $game)
			->setParameter('team', $team)
			->getQuery()
			->getResult();
	}

//    /**
//     * @return TeamShelter[] Returns an array of TeamShelter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TeamShelter
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
