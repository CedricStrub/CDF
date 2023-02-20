<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SessionAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class,[
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('place', IntegerType::class,[
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('dateDebut', DateType::class,[
                'attr' => ['class' => 'input'],
                'widget' => 'single_text',
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('dateFin', DateType::class,[
                'attr' => ['class' => 'input'],
                'widget' => 'single_text',
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('participer', EntityType::class,[
                'class' => Stagiaire::class,
                'multiple' => true,
                'attr' => ['class' => 'input-multi'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('formateur', EntityType::class,[
                'class' => Formateur::class,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('formation', EntityType::class,[
                'class' => Formation::class,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
            ])
            ->add('submit', SubmitType::class, [
				'label' => 'Ajouter Session',
                'attr' => ['class' => 'bouton'],
			]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
