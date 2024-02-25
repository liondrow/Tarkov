<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Wallet;
use App\Exception\BadUserException;
use App\Exception\GameNotFoundException;
use App\Exception\InvalidInvoiceDataException;
use App\Exception\InvalidWalletSumException;
use App\Exception\NotFoundException;
use App\Service\GameService;
use App\Service\WalletService;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/')]
class WalletController extends AbstractController
{

	public function __construct(private readonly GameService $gameService, private readonly WalletService $walletService) {}

	/**
	 * @throws GameNotFoundException
	 */
	#[Route('wallet_invoice', name: 'app_wallets_invoice', methods: ["POST"])]
	public function walletInvoice(Request $request): JsonResponse
	{
		$activeGame = $this->gameService->getCurrentGame();
		$data = json_decode($request->getContent(), true);
		$teamTo = $data['teamTo'];
		$sum = $data['sum'];
		if(empty($teamTo) || empty($sum)) {
			throw new InvalidInvoiceDataException("Не заполнены обязательные поля");
		}
		/** @var User $user */
		$user = $this->getUser();
		$newWalletValue = $this->walletService->sendInvoice($activeGame, $user, $teamTo, $sum);
		return new JsonResponse(['newWalletValue' => $newWalletValue]);
	}

	/**
	 * @throws GameNotFoundException
	 */
	#[Route('invoice_history', name: 'app_wallets_history', methods: ["GET"])]
	public function getInvoiceHistory(): JsonResponse
	{
		$activeGame = $this->gameService->getCurrentGame();
		/** @var User $team */
		$team = $this->getUser();
		$history = $this->walletService->getInvoiceHistoryForGame($activeGame, $team);
		return new JsonResponse($history);
	}


	/**
	 * @throws GameNotFoundException
	 * @throws BadUserException|NotFoundException
	 */
	#[Route('wallet', name: 'app_wallet')]
    public function index(): JsonResponse
    {
	    $activeGame = $this->gameService->getCurrentGame();
	    /** @var User $user */
	    $user = $this->getUser();
		if(!$user || !$user->isEnabled()) {
			throw new BadUserException("Команда не найдена или не активна");
		}
		$wallet = $user->getWallets()->filter(function (Wallet $wallet) use ($activeGame) {
			return $wallet->getGame() === $activeGame;
		})->toArray();
		$resWallet = (!empty($wallet) && is_array($wallet)) ? current($wallet) : $wallet;
		if(empty($resWallet)) {
			throw new NotFoundException("Кошелек не создан для данной команды");
		}

		return new JsonResponse($resWallet->getValue() ?? 0);
    }

	#[Route('wallet_available_teams', name: 'app_teams')]
	public function availableTeams(): JsonResponse
	{
		$activeGame = $this->gameService->getCurrentGame();
		$teams = $activeGame->getUsers()->toArray();
		$resTeams = [];
		foreach($teams as $team) {
			if($team == $this->getUser()) {
				continue;
			}
			$resTeams[] = $team->getUserIdentifier();
		}
		return new JsonResponse($resTeams);
	}

}
