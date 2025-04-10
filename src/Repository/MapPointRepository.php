<?php

namespace App\Repository;

use App\Entity\MapPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class MapPointRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, MapPoint::class);
	}

	public function getMapPoints(bool $isOpenStashes): array
	{
		$qb = $this->createQueryBuilder('m');
		if (!$isOpenStashes)
		{
			$qb->andWhere('m.isStash = :isStash')
			   ->setParameter('isStash', false);
		}
		return $qb->andWhere('m.enabled = :enabled')
		          ->setParameter('enabled', true)
		          ->orderBy('m.id', 'ASC')
		          ->getQuery()
		          ->getResult();
	}

}
