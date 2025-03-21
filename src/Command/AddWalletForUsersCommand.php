<?php

namespace App\Command;

use App\Entity\Game;
use App\Entity\QuestProgress;
use App\Entity\User;
use App\Entity\Wallet;
use App\Enum\QuestStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-wallets',
    description: 'Создание кошельков игрокам',
)]
class AddWalletForUsersCommand extends Command
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
			$io->error('Проблема с игроками');
			return Command::FAILURE;
		}

		//$this->entityManager->getRepository(Wallet::class)->clearTable();
	    foreach($users as $user) {
			$this->createWallet($user, $activeGame);
		}

        $io->success(sprintf("Для %d игроков были созданы кошельки", count($users)));

        return Command::SUCCESS;
    }

	private function createWallet(User $user, Game $activeGame): void
	{
		$wallet = new Wallet();
		$wallet->setUser($user);
		$wallet->setGame($activeGame);
		$wallet->setValue(3000);
		$this->entityManager->persist($wallet);
		$this->entityManager->flush();
	}

	private function checkUsersForGame(Game $game): mixed
	{
		$users = $game->getUsers()->filter(function(User $user) {
			return ($user->isEnabled() && !$user->isSeller());
		})->getValues();
		if(empty($users)) {
			return false;
		}
		return $users;
	}

}
