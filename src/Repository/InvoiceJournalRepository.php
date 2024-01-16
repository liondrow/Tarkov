<?php

namespace App\Repository;

use App\Entity\InvoiceJournal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InvoiceJournal>
 *
 * @method InvoiceJournal|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceJournal|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceJournal[]    findAll()
 * @method InvoiceJournal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceJournalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceJournal::class);
    }

//    /**
//     * @return InvoiceJournal[] Returns an array of InvoiceJournal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InvoiceJournal
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
