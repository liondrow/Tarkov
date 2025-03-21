<?php

namespace App\Command;

use App\Entity\Game;
use App\Entity\QuestProgress;
use App\Entity\User;
use App\Enum\QuestStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:distribute-quests',
    description: 'Начальное распределение квестов по командам, с учетом указанных веток',
)]
class AddQuestsForUsersCommand extends Command
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
			$io->error('Проблема с командами или не всем командам назначены ветки квестов');
			return Command::FAILURE;
		}

		$this->entityManager->getRepository(QuestProgress::class)->clearTable();
	    foreach($users as $user) {
			$distributedQuestCount = $this->distributeQuestForUser($user);
			$io->note(sprintf("Для команды %s было распределено %d квестов", $user->getNickName(), $distributedQuestCount));
		}

        $io->success('Квесты были распределены по командам, согласно указанным веткам');

        return Command::SUCCESS;
    }

	private function distributeQuestForUser(User $user): int
	{
		$distributedQuestCount = 0;
		$questBranch = $user->getQuestBranch();
		$quests = $questBranch->getQuests();
		foreach($quests as $quest) {
			$questProgress = new QuestProgress();
			$questProgress->setQuest($quest);
			$questProgress->setUser($user);
			$status = ($distributedQuestCount === 0 || empty($quest->getParent())) ? QuestStatus::ACTIVE : QuestStatus::QUEUE;
			$questProgress->setStatus($status);
			$questProgress->setEnabled(true);
			$this->entityManager->persist($questProgress);
			$distributedQuestCount++;
		}
		$this->entityManager->flush();
		return $distributedQuestCount;
	}

	private function checkUsersForGame(Game $game): mixed
	{
		$users = $game->getUsers()->filter(function(User $user) {
			return ($user->isEnabled() && !$user->isSeller());
		})->getValues();
		if(empty($users)) {
			return false;
		}
		foreach($users as $user) {
			if(empty($user->getQuestBranch())) {
				return false;
			}
		}
		return $users;
	}

}
