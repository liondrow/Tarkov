<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Entity\MarketItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MarketItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MarketItem::class;
    }

	public function configureActions(Actions $actions): Actions
	{

		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Создать лот');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Барахолка')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setEntityLabelInSingular(function (?MarketItem $item, ?string $pageName) {
				if($pageName == 'new') {
					return 'лот';
				} else if($pageName == 'edit') {
					return $item->getItem();
				}
			})
			;
	}


    public function configureFields(string $pageName): iterable
    {
        return [
	        AssociationField::new('game')->setQueryBuilder(function(QueryBuilder $queryBuilder) {
		        return $queryBuilder->andWhere('entity.enabled = :enabled')->setParameter('enabled', true);
	        }),
            IdField::new('id')->hideOnForm(),
            TextField::new('item'),
	        AssociationField::new('seller'),
            NumberField::new('price'),
	        NumberField::new('comission'),
	        BooleanField::new('enabled'),
	        DateTimeField::new('created')->setEmptyData(new \DateTime("now")),
        ];
    }
}
