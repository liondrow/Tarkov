<?php

namespace App\Controller\Admin;

use App\Entity\QuestProgress;
use App\Enum\QuestStatus;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class QuestProgressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuestProgress::class;
    }

	public function configureActions(Actions $actions): Actions
	{

		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Распределить квест');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Список распределений')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setEntityLabelInSingular(function (?QuestProgress $questStatus, ?string $pageName) {
				if($pageName == 'new') {
					return 'распределение';
				} else if($pageName == 'edit') {
					return $questStatus->getTeam()->getTeamName() . " / " . $questStatus->getQuest()->getName();
				}
			})
			;
	}

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('status')->setChoices(QuestStatus::cases()),
	        AssociationField::new('team')->setQueryBuilder(function (QueryBuilder $queryBuilder) {
		        return $queryBuilder->andWhere('entity.enabled = :enabled')->setParameter('enabled', true);
	        }),
	        AssociationField::new('quest')
        ];
    }

}
