<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Entity\Quest;
use App\Entity\QuestBranch;
use App\Entity\QuestProgress;
use App\Entity\User;
use App\Entity\Wallet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
	    $routeBuilder = $this->container->get(AdminUrlGenerator::class);
	    $url = $routeBuilder->setController(UserCrudController::class)->generateUrl();

	    return $this->redirect($url);
    }

	public function configureDashboard(): Dashboard
	{
		return Dashboard::new()
			->setTitle('Панель администратора')
			->setTranslationDomain('messages');
	}

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Команды', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Игры', 'fas fa-list', Game::class);
        yield MenuItem::linkToCrud('Кошельки', 'fas fa-list', Wallet::class);
        yield MenuItem::linkToCrud('Квесты', 'fas fa-list', Quest::class);
        yield MenuItem::linkToCrud('Ветки квестов', 'fas fa-list', QuestBranch::class);
        yield MenuItem::linkToCrud('Распределенные квесты', 'fas fa-list', QuestProgress::class);
    }
}
