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
class AddQuestsForCommandsCommand extends Command
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
		$teams = $this->checkTeamsForGame($activeGame);
		if(!$teams) {
			$io->error('Проблема с командами или не всем командам назначены ветки квестов');
			return Command::FAILURE;
		}

		$this->entityManager->getRepository(QuestProgress::class)->clearTable();
	    foreach($teams as $team) {
			$distributedQuestCount = $this->distributeQuestForTeam($team);
			$io->note(sprintf("Для команды %s было распределено %d квестов", $team->getTeamName(), $distributedQuestCount));
		}

        $io->success('Квесты были распределены по командам, согласно указанным веткам');

        return Command::SUCCESS;
    }

	private function distributeQuestForTeam(User $team): int
	{
		$distributedQuestCount = 0;
		$questBranch = $team->getQuestBranch();
		$quests = $questBranch->getQuests();
		foreach($quests as $quest) {
			$questProgress = new QuestProgress();
			$questProgress->setQuest($quest);
			$questProgress->setTeam($team);
			$status = ($distributedQuestCount === 0) ? QuestStatus::ACTIVE : QuestStatus::QUEUE;
			$questProgress->setStatus($status);
			$questProgress->setEnabled(true);
			$this->entityManager->persist($questProgress);
			$distributedQuestCount++;
		}
		$this->entityManager->flush();
		return $distributedQuestCount;
	}

	private function checkTeamsForGame(Game $game): mixed
	{
		$teams = $game->getUsers()->filter(function(User $user) {
			return ($user->isEnabled() && !$user->isSeller());
		})->getValues();
		if(empty($teams)) {
			return false;
		}
		foreach($teams as $team) {
			if(empty($team->getQuestBranch())) {
				return false;
			}
		}
		return $teams;
	}

}
