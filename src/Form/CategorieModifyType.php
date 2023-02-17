<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategorieModifyType extends AbstractType
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
            'choices' => $this->getCategorieType(),
            'autocomplete' => true,
            'label' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Ajouter Session',
        ]);
    }

    public function getCategorieType(): array
	{
		$categories = $this->doctrine->getRepository(Categorie::class)->findAll();

		$choices = [];
		foreach ($categories as $categorie) {
			$choices[$categorie->getNom()] = $categorie->getId();
		}

		return $choices;
	}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
