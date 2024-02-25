<?php

namespace App\Controller\Api;

use App\Entity\MarketItem;
use App\Entity\User;
use App\Exception\GameException;
use App\Exception\GameNotFoundException;
use App\Exception\NotFoundException;
use App\Model\LotDto;
use App\Service\GameService;
use App\Service\MarketService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class MarketController extends AbstractController
{

	public function __construct(
		private readonly GameService $gameService,
		private readonly EntityManagerInterface $entityManager,
		private readonly MarketService $marketService
	)
	{
	}

	/**
	 * @throws GameNotFoundException
	 */
	#[Route('/market', name: 'app_market')]
    public function market(): JsonResponse
    {
		$activeGame = $this->gameService->getCurrentGame();
		/** @var User $user */
		$user = $this->getUser();
		$lots = $this->entityManager->getRepository(MarketItem::class)->findActiveLots($activeGame, $user);
		$resLots = [];
		foreach($lots as $lot) {
			$resLots[] = LotDto::newFromEntity($lot);
		}
		return new JsonResponse($resLots);
    }

	/**
	 * @throws GameNotFoundException
	 * @throws NotFoundException
	 * @throws GameException
	 */
	#[Route('/market_buy', name: 'app_market_order')]
	public function orderLot(Request $request): JsonResponse
	{
		$response = new JsonResponse();
		$data = json_decode($request->getContent(), true);
		$activeGame = $this->gameService->getCurrentGame();
		/** @var User $user */
		$user = $this->getUser();
		$result = $this->marketService->makeOrder($activeGame, $data['lotId'], $user);
		$response->setData($result);

		return new JsonResponse($result);

	}
}
