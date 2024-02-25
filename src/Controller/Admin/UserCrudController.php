<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Closure;
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

	public function configureFields(string $pageName): iterable
	{
		$fields = [
			IdField::new('id')->hideOnForm(),
			TextField::new('username'),
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

		$fields[] = TextField::new('teamName');
		$fields[] = ChoiceField::new('side')->setChoices(["BEAR" => "BEAR", "USEC" => "USEC", "WILD" => "WILD"]);
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
