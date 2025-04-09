<?php

namespace App\Controller\Admin;

use App\Entity\ItemCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ItemCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ItemCategory::class;
    }

	public function configureActions(Actions $actions): Actions
	{
		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Создать категорию');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Список категорий')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setEntityLabelInSingular(function (?ItemCategory $category, ?string $pageName) {
				if($pageName == 'new') {
					return 'категория';
				} else if($pageName == 'edit') {
					return $category->getName();
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
		];
	}


}
