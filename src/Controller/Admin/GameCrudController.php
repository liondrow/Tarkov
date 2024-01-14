<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

	public function configureActions(Actions $actions): Actions
	{

		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Создать игру');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Список игр')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setEntityLabelInSingular(function (?Game $game, ?string $pageName) {
				if($pageName == 'new') {
					return 'игру';
				} else if($pageName == 'edit') {
					return $game->getName();
				}
			})
			;
	}


   public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
	        TextField::new('name'),
	        BooleanField::new('enabled'),
	        DateField::new('date'),
	        DateField::new('dateEnd'),
	        TextField::new('city')->hideOnIndex(),
	        TextField::new('polygon')->hideOnIndex(),
	        TextField::new('mapX')->hideOnIndex(),
	        TextField::new('mapY')->hideOnIndex(),
	        AssociationField::new('users')->hideOnIndex()->setFormTypeOptions(['by_reference' => false])
        ];
    }

}
