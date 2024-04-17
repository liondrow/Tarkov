<?php

namespace App\EventSubscriber;

use App\Entity\QuestProgress;
use App\Enum\QuestStatus;
use App\Service\GameService;
use App\Service\WalletService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class QuestProgressEasyAdminSubscriber implements EventSubscriberInterface
{

	public function __construct(
		private EntityManagerInterface $entityManager,
		private WalletService $walletService,
		private GameService $gameService
		)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			BeforeEntityUpdatedEvent::class => ['setActiveStatusToNextQuest']
		];
	}

	public function setActiveStatusToNextQuest(BeforeEntityUpdatedEvent $event)
	{
		$entity = $event->getEntityInstance();
		if(!($entity instanceof QuestProgress)) {
			return;
		}

		if($entity->getStatus() == QuestStatus::FINISHED) {
			$childQuests = $this->entityManager->getRepository(QuestProgress::class)->findQuestProgressByBranchAndParentQuest($entity->getQuest()->getId(), $entity->getTeam()->getId());
			if(!empty($childQuests)) {
				/** @var QuestProgress $childQuest */
				foreach($childQuests as $childQuest) {
					$childQuest->setStatus(QuestStatus::ACTIVE);
					$this->entityManager->persist($childQuest);
				}
			}
			/** Автоматическая выдача награды за квест */
			/*$sum = $entity->getQuest()->getReward();
			if($sum > 0) {
				$userTo = $entity->getTeam()->getUserIdentifier();
				$userFrom = $entity->getQuest()->getTarget();
				$game = $this->gameService->getCurrentGame();
				try
				{
					$this->walletService->sendInvoice($game, $userFrom, $userTo, $sum);
				} catch (\Exception $exception) {
					throw new \Exception("Возникла ошибка при зачислении награды за квест к счету");
				}
			}*/
		}
	}

}