<?php

namespace App\Repository;

use App\Entity\MapPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MapPoint>
 */
class MapPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MapPoint::class);
    }

	public function getMapPoints(bool $isOpenStashes): array
	{
		$qb = $this->createQueryBuilder('m');
		if(!$isOpenStashes) {
			$qb->andWhere('m.isStash = :isStash')
				->setParameter('isStash', false);
		}
		return $qb->orderBy('m.id', 'ASC')
		            ->getQuery()
		            ->getResult()
			;
	}

//    /**
//     * @return MapPoint[] Returns an array of MapPoint objects
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

//    public function findOneBySomeField($value): ?MapPoint
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
