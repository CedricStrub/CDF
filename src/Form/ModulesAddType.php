<?php

namespace App\Form;

use App\Entity\Modules;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModulesAddType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('categorie', EntityType::class,[
                'class' => Categorie::class,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('submit', SubmitType::class, [
				'label' => 'Ajouter Module',
                'attr' => ['class' => 'bouton'],
			]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Modules::class,
        ]);
    }
}
