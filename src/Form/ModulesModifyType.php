<?php

namespace App\Form;

use App\Entity\Modules;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModulesModifyType extends AbstractType
{
    private ManagerRegistry $doctrine;

	public function __construct(ManagerRegistry $doctrine)
	{
		$this->doctrine = $doctrine;
	}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', ChoiceType::class, [
            'choices' => $this->getModulesType(),
            'autocomplete' => true,
            'label' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Modifier Modules',
        ]);
    }

    public function getModulesType(): array
	{
		$modules = $this->doctrine->getRepository(Modules::class)->findAll();

		$choices = [];
		foreach ($modules as $module) {
			$choices[$module->getNom()] = $module->getId();
		}

		return $choices;
	}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Modules::class,
        ]);
    }
}
