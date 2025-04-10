<?php

namespace App\Controller\Admin;

use App\Entity\Shelter;
use App\Enum\QuestStatus;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ShelterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Shelter::class;
    }

	public function configureActions(Actions $actions): Actions
	{

		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Создать модуль');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Список модулей')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setEntityLabelInSingular(function (?Shelter $shelter, ?string $pageName) {
				if($pageName == 'new') {
					return 'модуль';
				} else if($pageName == 'edit') {
					return $shelter->getName();
				}
			})
			;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id')->hideOnForm(),
			BooleanField::new('enabled'),
			TextField::new('name'),
			AssociationField::new('game')->setQueryBuilder(function(QueryBuilder $queryBuilder) {
				return $queryBuilder->andWhere('entity.enabled = :enabled')->setParameter('enabled', true);
			}),
			TextEditorField::new('description'),
			TextEditorField::new('bonus'),
			BooleanField::new('isOpenStash'),
		];
	}


}
