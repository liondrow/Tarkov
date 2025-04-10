<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Entity\Item;
use App\Entity\ItemCategory;
use App\Entity\MapPoint;
use App\Entity\MarketInvoice;
use App\Entity\MarketItem;
use App\Entity\Quest;
use App\Entity\QuestBranch;
use App\Entity\QuestProgress;
use App\Entity\Shelter;
use App\Entity\UserShelter;
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
	    yield MenuItem::linkToRoute('Статистика', 'fa fa-chart-line', 'admin_stats');
        yield MenuItem::linkToCrud('Игроки', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Игры', 'fas fa-flushed', Game::class);
        yield MenuItem::linkToCrud('Кошельки', 'fas fa-wallet', Wallet::class);
        yield MenuItem::linkToCrud('Предметы', 'fas fa-lemon', Item::class);
        yield MenuItem::linkToCrud('Категории предметов', 'fas fa-list', ItemCategory::class);
        yield MenuItem::linkToCrud('Барахолка', 'fas fa-toolbox', MarketItem::class);
        yield MenuItem::linkToCrud('Покупки на барахолке', 'fas fa-handshake', MarketInvoice::class);
        yield MenuItem::linkToCrud('Квесты', 'fas fa-ticket', Quest::class);
        yield MenuItem::linkToCrud('Ветки квестов', 'fas fa-list', QuestBranch::class);
        yield MenuItem::linkToCrud('Распределенные квесты', 'fas fa-thumbtack', QuestProgress::class);
        yield MenuItem::linkToCrud('Метки карты', 'fas fa-map-marker', MapPoint::class);
        yield MenuItem::linkToCrud('Убежище', 'fas fa-warehouse', Shelter::class);
        yield MenuItem::linkToCrud('Распределенные модули', 'fas fa-wrench', UserShelter::class);
    }
}
