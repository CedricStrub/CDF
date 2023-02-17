<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormationModifyType extends AbstractType
{
    private ManagerRegistry $doctrine;

	public function __construct(ManagerRegistry $doctrine)
	{
		$this->doctrine = $doctrine;
	}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('intitule', ChoiceType::class, [
            'choices' => $this->getFormationType(),
            'autocomplete' => true,
            'label' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Modifier Formation',
        ]);
    }

    public function getFormationType(): array
	{
		$formations = $this->doctrine->getRepository(Formation::class)->findAll();

		$choices = [];
		foreach ($formations as $formation) {
			$choices[$formation->getIntitule()] = $formation->getId();
		}

		return $choices;
	}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
