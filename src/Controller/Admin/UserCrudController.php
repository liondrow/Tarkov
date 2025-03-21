<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Closure;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

	public function __construct(
		public UserPasswordHasherInterface $userPasswordHasher
	)
	{
	}

	public static function getEntityFqcn(): string
	{
		return User::class;
	}

	public function configureActions(Actions $actions): Actions
	{
		$actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {
			return $action->setLabel('Создать игрока');
		});
		$actions->add(Crud::PAGE_NEW, Action::INDEX);
		$actions->add(Crud::PAGE_EDIT, Action::INDEX);
		return parent::configureActions($actions);
	}


	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInPlural('Список игроков')
			->setSearchFields(['id', 'name'])
			->setDefaultSort(['id' => 'ASC'])
			->setPageTitle(Crud::PAGE_NEW, "Новый игрок")
			->setPageTitle(Crud::PAGE_INDEX, "Список игроков")
			->setEntityLabelInSingular(function (?User $user, ?string $pageName) {
				if($pageName == 'new') {
					return 'игрока';
				} else if($pageName == 'edit') {
					return $user->getNickname();
				}
			})
			;
	}

	public function configureFields(string $pageName): iterable
	{
		$adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
		$fields = [
			IdField::new('id')->hideOnForm(),
			TextField::new('username'),
			TextField::new('nickname')->formatValue(function ($value, $entity) use ($adminUrlGenerator) {
				$url = $adminUrlGenerator
					->setController(self::class)
					->setAction('edit')
					->setEntityId($entity->getId())
					->generateUrl();

				return sprintf('<a href="%s">%s</a>', $url, $value);
			}),
			BooleanField::new('enabled'),
		];

		$password = TextField::new('password')
			->setFormType(RepeatedType::class)
			->setFormTypeOptions([
				'type' => PasswordType::class,
				'first_options' => ['label' => 'Пароль'],
				'second_options' => ['label' => 'Повтор пароля'],
				'mapped' => false,
			])
			->setRequired($pageName === Crud::PAGE_NEW)
			->onlyOnForms();
		$fields[] = $password;
		$fields[] = TextField::new('airsoftTeam');
		$fields[] = DateField::new('createdAt');
		$fields[] = AssociationField::new('questBranch')->hideOnIndex();
		$fields[] = BooleanField::new('isPmc')->hideOnIndex();
		$fields[] = BooleanField::new('seller')->hideOnIndex();
		$fields[] = BooleanField::new('isAuctioner')->hideOnIndex();

		return $fields;
	}


	public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
	{
		$formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
		return $this->addPasswordEventListener($formBuilder);
	}

	public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
	{
		$formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
		return $this->addPasswordEventListener($formBuilder);
	}

	private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
	{
		return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
	}

	private function hashPassword(): Closure
	{
		return function ($event)
		{
			$form = $event->getForm();
			if (!$form->isValid())
			{
				return;
			}
			$password = $form->get('password')->getData();
			if ($password === null)
			{
				return;
			}

			$hash = $this->userPasswordHasher->hashPassword($form->getData(), $password);
			$form->getData()->setPassword($hash);
		};
	}
}
