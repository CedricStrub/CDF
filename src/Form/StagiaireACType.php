<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireACType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('addParticiper', EntityType::class, [
				'class' => Stagiaire::class,
				'autocomplete' => true,
				'mapped' => false,
				'label' => false,
			])
			->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
				/** @var Session $session */
				$session = $event->getData();
				$stagiaire = $event->getForm()->get('addParticiper')->getData();
				$session->addParticiper($stagiaire);
			});
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Session::class,
		]);
	}
}
