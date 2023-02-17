<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireModifyType extends AbstractType
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
            'choices' => $this->getStagiaireType(),
            'autocomplete' => true,
            'label' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Modifier Formation',
        ]);
    }

    public function getStagiaireType(): array
	{
		$stagiaires = $this->doctrine->getRepository(Stagiaire::class)->findAll();

		$choices = [];
		foreach ($stagiaires as $stagiaire) {
			$choices[$stagiaire->getNom()." - ".$stagiaire->getPrenom()] = $stagiaire->getId();
		}

		return $choices;
	}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
