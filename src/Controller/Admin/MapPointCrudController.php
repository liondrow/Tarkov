<?php

namespace App\Controller\Admin;

use App\Entity\MapPoint;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class MapPointCrudController extends AbstractCrudController
{

	protected AdminUrlGenerator $adminUrlGenerator;

	public function __construct(AdminUrlGenerator $adminUrlGenerator)
	{
		$this->adminUrlGenerator = $adminUrlGenerator;
	}

    public static function getEntityFqcn(): string
    {
        return MapPoint::class;
    }

	public function edit(AdminContext $context)
	{
		if ($context->getRequest()->query->has('duplicate')) {
			$entity = $context->getEntity()->getInstance();
			/** @var MapPoint $cloned */
			$cloned = clone $entity;
			$context->getEntity()->setInstance($cloned);
		}

		return parent::edit($context);
	}

	public function configureActions(Actions $actions): Actions
	{
		$duplicate = Action::new('duplicate', false)
			->setLabel("Копировать")
			->linkToUrl(
				fn (MapPoint $entity) => $this->adminUrlGenerator
					->setAction(Action::EDIT)
					->setEntityId($entity->getId())
					->set('duplicate', '1')
					->generateUrl()
			);

		$actions->add(Crud::PAGE_INDEX, $duplicate);
		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {return $action->setLabel('Создать метку');});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInSingular('Метка')
			->setEntityLabelInPlural('Список меток')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setPaginatorPageSize(80)
			->setEntityLabelInSingular(function (?MapPoint $mapPoint, ?string $pageName) {
				if($pageName == 'new') {
					return 'метку';
				} else if($pageName == 'edit') {
					return $mapPoint->getId();
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
			TextField::new('latitude'),
			TextField::new('longitude'),
			BooleanField::new('isStash'),
			TextField::new('clipRect')
		];
	}
}
