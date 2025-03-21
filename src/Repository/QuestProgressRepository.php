<?php

namespace App\Repository;

use App\Entity\Quest;
use App\Entity\QuestBranch;
use App\Entity\QuestProgress;
use App\Enum\QuestStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestProgress>
 *
 * @method QuestProgress|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestProgress|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestProgress[]    findAll()
 * @method QuestProgress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestProgress::class);
    }

	public function clearTable(): void
	{
		$this->createQueryBuilder('q')
			->delete()
			->getQuery()
			->getResult();
	}

	public function findQuestProgressByBranchAndParentQuest(int $parentQuest, int $userId)
	{
		return $this->createQueryBuilder('qp')
			->join('qp.quest', 'q')
			->where('q.parent = :parent')
			->andWhere('qp.user = :user')
			->andWhere('qp.status = :status')
			->setParameter('parent', $parentQuest)
			->setParameter('user', $userId)
			->setParameter('status', QuestStatus::QUEUE)
			->getQuery()
			->getResult();
	}

//    /**
//     * @return QuestProgress[] Returns an array of QuestProgress objects
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

//    public function findOneBySomeField($value): ?QuestProgress
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
