<?php

namespace App\Controller\Api;

use App\Entity\MarketInvoice;
use App\Entity\MarketItem;
use App\Entity\User;
use App\Entity\Wallet;
use App\Exception\GameNotFoundException;
use App\Exception\NotFoundException;
use App\Model\LotDto;
use App\Service\GameService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class MarketController extends AbstractController
{

	public function __construct(
		private readonly GameService $gameService,
		private readonly EntityManagerInterface $entityManager
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
	 */
	#[Route('/market_buy', name: 'app_market_order')]
	public function orderLot(Request $request): JsonResponse
	{
		$data = json_decode($request->getContent(), true);
		$activeGame = $this->gameService->getCurrentGame();
		$lot = $this->entityManager->getRepository(MarketItem::class)->findOneBy(['game' => $activeGame, 'id' => $data['lotId'], 'enabled' => true]);
		if(!$lot) {
			throw new NotFoundException("Лот не найден");
		}

		try
		{
			$marketInvoice = new MarketInvoice();
			$marketInvoice->setDate(new \DateTime());
			$marketInvoice->setBuyer($this->getUser());
			$marketInvoice->setLot($lot);
			$this->entityManager->persist($marketInvoice);

			$buyerWallet = $this->entityManager->getRepository(Wallet::class)->findOneBy(['game' => $activeGame, 'team' => $this->getUser()]);
			$newBuyerWallet = $buyerWallet->getValue() - $lot->getPrice();
			$buyerWallet->setValue($newBuyerWallet);
			$this->entityManager->persist($buyerWallet);

			$sellerWallet = $this->entityManager->getRepository(Wallet::class)->findOneBy(['game' => $activeGame, 'team' => $lot->getSeller()]);
			$sellerWallet->setValue($sellerWallet->getValue()+$lot->getPrice());
			$this->entityManager->persist($sellerWallet);

			$lot->setEnabled(false);
			$this->entityManager->persist($lot);

			$this->entityManager->flush();
			return new JsonResponse(['status' => "OK", 'buyerWallet' => $newBuyerWallet]);
		} catch (\Exception) {
			throw new \Exception("Возникла ошибка при покупке, попробуйте еще раз или обратитесь к организатору");
		}
	}
}
