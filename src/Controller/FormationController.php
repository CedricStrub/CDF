<?php

namespace App\Controller;

use App\Entity\Formation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $formations = $doctrine->getRepository(Formation::class)->findAll();

        $form = $this->createFormBuilder()
            ->add('formation', EntityType::class,[
                'class' => Formation::class,
                'autocomplete' => true,
                'placeholder' => 'Intitulé',
                'attr' => ['class' => 'bar' ]
            ])
            ->getForm()
        ;

        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'formations' => $formations,
            'form' => $form->createView(),
        ]);
    }
}
