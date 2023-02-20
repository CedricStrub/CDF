<?php

namespace App\Form;

use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormateurModifyType extends AbstractType
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
            'choices' => $this->getFormateurType(),
            'autocomplete' => true,
            'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Modifier Formateur',
            'attr' => ['class' => 'bouton'],
        ]);
    }

    public function getFormateurType(): array
	{
		$formateurs = $this->doctrine->getRepository(Formateur::class)->findAll();

		$choices = [];
		foreach ($formateurs as $formateur) {
			$choices[$formateur->getNom()." - ".$formateur->getPrenom()] = $formateur->getId();
		}

		return $choices;
	}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formateur::class,
        ]);
    }
}
