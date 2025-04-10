<?php

namespace App\Controller\Api;

use App\Model\MapPointDto;
use App\Repository\MapPointRepository;
use App\Repository\UserRepository;
use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/')]
class MapController extends AbstractController
{

	public function __construct(
		private readonly MapPointRepository $mapPointRepository,
		private readonly UserRepository $userRepository)
	{
	}
	#[Route('map', name: 'app_map')]
	public function getMapPoints(GameService $gameService): JsonResponse
	{
		$activeGame = $gameService->getCurrentGame();
		$user = $this->getUser();
		$isOpenStash = $this->userRepository->isUserOpenStashes($activeGame, $user->getId());
		$mapPoints = $this->mapPointRepository->getMapPoints($isOpenStash);
		$resMapPoints = [];
		foreach ($mapPoints as $mapPoint) {
			$resMapPoints[$mapPoint->getId()] = MapPointDto::newFromEntity($mapPoint);
		}
		return new JsonResponse($resMapPoints);
	}
}