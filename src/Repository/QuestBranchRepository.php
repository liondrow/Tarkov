<?php

namespace App\Repository;

use App\Entity\QuestBranch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestBranch>
 *
 * @method QuestBranch|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestBranch|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestBranch[]    findAll()
 * @method QuestBranch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestBranchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestBranch::class);
    }

//    /**
//     * @return QuestBranch[] Returns an array of QuestBranch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuestBranch
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
