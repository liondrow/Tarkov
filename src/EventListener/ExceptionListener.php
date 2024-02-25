<?php
/*
 * Copyright (c) 2023.
 * This file is part of the Sentima application.
 * (c) Sentima - Ivan Sereda <liondrow2@yandex.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventListener;

use App\Exception\GameException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
	public function __invoke(ExceptionEvent $event): void
	{
		$exception = $event->getThrowable();
		if($exception instanceof GameException)
		{
			$response = new JsonResponse([
				'message' => $exception->getMessage()
			]);
			$response->setStatusCode(Response::HTTP_BAD_REQUEST);

			$event->setResponse($response);
		}

	}
}