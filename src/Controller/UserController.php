<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class UserController extends AbstractController
{
    #[Route('/user-data', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
		$users = $entityManager->getRepository(User::class)->findOneBy(['username'=>'liondrow']);
        return new JsonResponse(['id' => $users->getUserIdentifier()]);
    }
}
