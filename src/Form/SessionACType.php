<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SessionACType extends AbstractType
{
	private ManagerRegistry $doctrine;

	public function __construct(ManagerRegistry $doctrine)
	{
		$this->doctrine = $doctrine;
	}

	public function buildForm(FormBuilderInterface $builder, array $options,): void
	{
		$builder
			->add('intitule', ChoiceType::class, [
				'choices' => $this->getSessionType(),
				'autocomplete' => true,
				'label' => false,
			])
			->add('dateDebut', DateType::class, [
				'required' => true,
				'widget' => 'single_text',
				'label' => 'Date de début',
				'attr' => ['class' => 'calendar']
			])
			->add('submit', SubmitType::class, [
				'label' => 'Ajouter Session',
				'attr' => ['class' => 'submit']
			]);
	}

	public function getSessionType(): array
	{
		$sessions = $this->doctrine->getRepository(Session::class)->findAll();

		$choices = [];
		foreach ($sessions as $session) {
			$choices[$session->getIntitule()] = $session->getId();
		}

		return $choices;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Session::class,
		]);
	}
}
