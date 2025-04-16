<?php

namespace App\Command;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'create-admin',
    description: 'Создает администратора',
)]
class CreateAdminCommand extends Command
{
    public function __construct(public EntityManagerInterface $em, public UserPasswordHasherInterface $hasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('login', InputArgument::OPTIONAL, 'Логин')
            ->addArgument('password', InputArgument::OPTIONAL, 'Пароль')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $login = $input->getArgument('login');
        $pass = $input->getArgument('password');

        if (!$login) {
            $io->warning('Вы не ввели email пользователя');
        }

	    if (!$pass) {
		    $io->warning('Вы не ввели пароль');
	    }

		$user = new Admin();
		$user->setEmail($login);
		$user->setPassword($this->hasher->hashPassword($user, $pass));
		$user->setRoles(['ROLE_ADMIN']);

		$this->em->persist($user);
		$this->em->flush();

        $io->success(sprintf("Администратор создан! Логин: %s / Пароль: %s", $login, $pass));

        return Command::SUCCESS;
    }
}
