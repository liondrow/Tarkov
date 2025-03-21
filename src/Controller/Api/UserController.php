<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class UserController extends AbstractController
{
    #[Route('/user-data', name: 'app_user')]
    public function index(): JsonResponse
    {
		/** @var User $user */
		$user = $this->getUser();
		$userData['nickname'] = $user->getNickname();
		$userData['uid'] = $user->getUserIdentifier();
        return new JsonResponse($userData);
    }
}
