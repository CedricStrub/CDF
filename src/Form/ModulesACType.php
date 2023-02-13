<?php

namespace App\Form;

use App\Entity\Modules;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModulesACType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('module', EntityType::class, [
				'class' => Modules::class,
				'autocomplete' => true,
				'placeholder' => 'Nom du Module',
				'attr' => ['class' => 'bar'],
				'mapped' => false,
			])
			->add('duree', NumberType::class, [
				'label' => 'Durée (en heures)',
				'attr' => ['class' => 'bar'],
				'mapped' => false,
			])
			->add('submit', SubmitType::class, [
				'label' => 'Ajouter Module',
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Modules::class,
		]);
	}
}
