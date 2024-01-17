<?php

namespace App\Controller\Api;

use App\Entity\QuestProgress;
use App\Entity\User;
use App\Enum\QuestStatus;
use App\Model\QuestDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/')]
class QuestController extends AbstractController
{

	public function __construct(private readonly EntityManagerInterface $entityManager)
	{
	}

	#[Route('quests', name: 'app_quests')]
    public function getTeamQuests(): JsonResponse
    {
		/** @var User $team */
		$team = $this->getUser();
	    $questsProgresses = $this->entityManager->getRepository(QuestProgress::class)->findBy(['team' => $team, 'status' => QuestStatus::ACTIVE]);
		$quests = [];
		foreach($questsProgresses as $progress) {
			$quests[] = QuestDto::newFromEntity($progress->getQuest());
		}
		return new JsonResponse($quests);
    }

	#[Route('finished_quests', name: 'app_finished_quests')]
	public function getFinishedTeamQuests(): JsonResponse
	{
		/** @var User $team */
		$team = $this->getUser();
		$questsProgresses = $this->entityManager->getRepository(QuestProgress::class)->findBy(['team' => $team, 'status' => QuestStatus::FINISHED]);
		$quests = [];
		foreach($questsProgresses as $progress) {
			$quests[] = QuestDto::newFromEntity($progress->getQuest());
		}
		return new JsonResponse($quests);
	}
}
