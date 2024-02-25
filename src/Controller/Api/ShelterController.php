<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Exception\GameNotFoundException;
use App\Service\GameService;
use App\Service\ShelterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ShelterController extends AbstractController
{
	/**
	 * @throws GameNotFoundException
	 */
	#[Route('/shelters', name: 'app_shelter')]
    public function index(ShelterService $shelterService, GameService $gameService): JsonResponse
    {
		$activeGame = $gameService->getCurrentGame();
		/** @var User $user */
		$user = $this->getUser();
		$shelters = $shelterService->getSheltersForTeam($activeGame, $user);
		return new JsonResponse($shelters);
    }
}
