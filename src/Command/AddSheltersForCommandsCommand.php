<?php

namespace App\Command;

use App\Entity\Game;
use App\Entity\QuestProgress;
use App\Entity\Shelter;
use App\Entity\UserShelter;
use App\Entity\User;
use App\Enum\QuestStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-shelters',
    description: 'Маппинг модулей убежища по всем командам',
)]
class AddSheltersForCommandsCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

		$activeGame = $this->entityManager->getRepository(Game::class)->getActiveGame();
		if(empty($activeGame)) {
			$io->error('Указанная игра не найдена или не активна');
			return Command::INVALID;
		}

		$users = $this->checkUsersForGame($activeGame);
		if(!$users) {
			$io->error('Проблема с командами');
			return Command::FAILURE;
		}

		$this->entityManager->getRepository(UserShelter::class)->clearTable();
	    foreach($users as $user) {
			$distributedShelterCount = $this->distributeShelterForUser($activeGame, $user);
			$io->note(sprintf("Для команды %s было распределено %d модулей убежища", $user->getNickName(), $distributedShelterCount));
		}

        $io->success('Модули убежища были распределены по командам, согласно указанным веткам');

        return Command::SUCCESS;
    }

	private function distributeShelterForUser(Game $game, User $user): int
	{
		$distributedShelterCount = 0;
		$shelters = $game->getShelters()->filter(function(Shelter $shelter) {
			return $shelter->isEnabled();
		})->getValues();
		foreach($shelters as $shelter) {
			$userShelter = new UserShelter();
			$userShelter->setUser($user);
			$userShelter->setGame($game);
			$userShelter->setShelter($shelter);
			$userShelter->setEnabled(false);

			$this->entityManager->persist($userShelter);
			$distributedShelterCount++;
		}
		$this->entityManager->flush();
		return $distributedShelterCount;
	}

	private function checkUsersForGame(Game $game): mixed
	{
		$users = $game->getUsers()->filter(function(User $user) {
			return ($user->isEnabled() && $user->isIsPmc());
		})->getValues();
		if(empty($users)) {
			return false;
		}
		return $users;
	}

}
