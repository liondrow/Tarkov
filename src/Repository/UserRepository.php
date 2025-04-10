<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Shelter;
use App\Entity\User;
use App\Entity\UserShelter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

	public function loadUserByIdentifier(string $username): ?UserInterface
	{
		$entityManager = $this->getEntityManager();
		$resUsers = [];
		$users = $entityManager->getRepository(Game::class)->findOneBy(['enabled' => true])->getUsers()->toArray();
		if(!empty($users)) {
			foreach($users as $user) {
				$resUsers[] = $user->getId();
			}
		}

		return $entityManager->createQuery(
			'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :username
                AND u IN (:users) 
                AND u.enabled = 1'
		)
			->setParameter('username', $username)
			->setParameter('users', $resUsers)
			->getOneOrNullResult();
	}

	public function isUserOpenStashes(Game $game, int $userId): bool
	{
		$entityManager = $this->getEntityManager();
		$result = $entityManager->createQuery(
			'SELECT u.id
				FROM App\Entity\UserShelter u
				JOIN u.shelter s
				WHERE u.game = :game
				AND u.user = :userId
				AND u.enabled = 1
				AND s.enabled = 1
				AND s.isOpenStash = 1
				'
		)
			->setParameter('game', $game)
			->setParameter('userId', $userId)
			->getOneOrNullResult();

		return $result !== null;
	}
}
