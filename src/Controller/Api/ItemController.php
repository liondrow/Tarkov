<?php

namespace App\Controller\Api;

use App\Model\ItemDto;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/')]
class ItemController extends AbstractController
{

	public function __construct(private readonly ItemRepository $itemRepository)
	{
	}

	#[Route('items', name: 'app_items')]
	public function priceList(): JsonResponse
	{
		$products = $this->itemRepository->findBy(["enabled" => true]);
		$resProducts = [];
		foreach ($products as $product) {
			$resProducts[$product->getCategory()->getId()]['name'] = $product->getCategory()->getName();
			$resProducts[$product->getCategory()->getId()]['items'][] = ItemDto::newFromEntity($product);
		}
		return new JsonResponse($resProducts);
	}
}