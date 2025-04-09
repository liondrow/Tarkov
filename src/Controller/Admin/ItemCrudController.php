<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }

	public function configureActions(Actions $actions): Actions
	{
		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Создать предмет');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Список предметов')
			->setSearchFields(['id', 'name', 'category.name'])
			->setDefaultSort(['id' => 'ASC'])
			->setEntityLabelInSingular(function (?Item $item, ?string $pageName) {
				if($pageName == 'new') {
					return 'предмет';
				} else if($pageName == 'edit') {
					return $item->getName();
				}
			})
			;
	}

	public function configureFields(string $pageName): iterable
	{
		$adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
		return [
			IdField::new('id')->hideOnForm(),
			BooleanField::new('enabled'),
			TextField::new('name')->formatValue(function ($value, $entity) use ($adminUrlGenerator) {
				$url = $adminUrlGenerator
					->setController(self::class)
					->setAction('edit')
					->setEntityId($entity->getId())
					->generateUrl();

				return sprintf('<a href="%s">%s</a>', $url, $value);
			}),
			AssociationField::new('category')->setQueryBuilder(function(QueryBuilder $queryBuilder) {
				return $queryBuilder->andWhere('entity.enabled = :enabled')->setParameter('enabled', true);
			}),
			NumberField::new('praporPrice'),
			NumberField::new('terapevtPrice'),
			NumberField::new('baraholshikPrice'),
		];
	}


}
