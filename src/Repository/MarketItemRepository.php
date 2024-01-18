<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\MarketItem;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MarketItem>
 *
 * @method MarketItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketItem[]    findAll()
 * @method MarketItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketItem::class);
    }

	public function findActiveLots(Game $game, User $currentUser)
	{
		return $this->createQueryBuilder('m')
			->andWhere('m.game = :game')
			->andWhere('m.enabled = :enabled')
			->andWhere('m.seller != :user')
			->setParameter('game', $game)
			->setParameter('enabled', true)
			->setParameter('user', $currentUser)
			->orderBy('m.created', 'ASC')
			->getQuery()
			->getResult();
	}

//    /**
//     * @return MarketItem[] Returns an array of MarketItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MarketItem
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
