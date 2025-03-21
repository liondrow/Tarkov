<?php

namespace App\Controller\Admin;

use App\Entity\Quest;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quest::class;
    }

	public function configureActions(Actions $actions): Actions
	{

		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Создать квест');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Список квестов')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setEntityLabelInSingular(function (?Quest $quest, ?string $pageName) {
				if($pageName == 'new') {
					return 'квест';
				} else if($pageName == 'edit') {
					return $quest->getName();
				}
			})
			;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id')->hideOnForm(),
			TextField::new('name'),
			TextEditorField::new('description'),
			IntegerField::new('reward'),
			AssociationField::new('target')->setQueryBuilder(function(QueryBuilder $queryBuilder) {
				return $queryBuilder->andWhere('entity.seller = :seller')->setParameter('seller', true);
			}),
			AssociationField::new('branch')->setQueryBuilder(function(QueryBuilder $queryBuilder) {
				return $queryBuilder->andWhere('entity.enabled = :enabled')->setParameter('enabled', true);
			}),
			AssociationField::new('parent')
		];
	}

}
