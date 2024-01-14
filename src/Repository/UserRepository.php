<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\User;
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
		$resTeams = [];
		$game = $entityManager->getRepository(Game::class)->findOneBy(['enabled' => true]);
		$teams = $entityManager->getRepository(Game::class)->findOneBy(['enabled' => true])->getUsers()->toArray();
		if(!empty($teams)) {
			foreach($teams as $team) {
				$resTeams[] = $team->getId();
			}
		}

		return $entityManager->createQuery(
			'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :username
                AND u IN (:teams)'
		)
			->setParameter('username', $username)
			->setParameter('teams', $resTeams)
			->getOneOrNullResult();
	}
}
