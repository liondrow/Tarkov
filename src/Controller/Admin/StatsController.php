<?php

namespace App\Controller\Admin;

use App\Service\Manager\StatisticManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatsController extends AbstractController
{
	#[Route('/admin/stats', name: 'admin_stats')]
	public function index(StatisticManager $statisticManager): Response
	{
		$totalPlayers = $statisticManager->getTotalPlayers();
		$finishedQuestCount = $statisticManager->getFinishedQuestCount();
		$mostUsersQuestProgress = $statisticManager->getMostUsersQuestCount();
		$mostReachableUsers = $statisticManager->getMostReachableUsers();
		$mostReachableSellers = $statisticManager->getMostReachableSellers();

		return $this->render('admin/stats.html.twig', [
			'totalPlayers' => $totalPlayers,
			'finishedQuestCount' => $finishedQuestCount,
			'mostReachableUsers' => $mostReachableUsers,
			'mostReachableSellers' => $mostReachableSellers,
			'mostUsersQuestProgress' => $mostUsersQuestProgress,
		]);
	}
}
