<?php

namespace App\Controller;

use doctrine;
use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Modules;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use DateTime;
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

        $data = [];

        foreach($formations as $formation){
            $sessions = $doctrine->getRepository(Session::class)->findBy(['formation' => $formation->getId()]);

            $dureeTotal = 0;
            $places = 100;
            $date = new \DateTime();
            $dateD = $date;
            $dateF = $date;
            $progression = 0;

            foreach($sessions as $session){
                $modules = $doctrine->getRepository(Programme::class)->findBy(['session' => $session->getId()]);
                if($session->getPlace() < $places){
                    $places = $session->getPlace();
                }
                foreach($modules as $module){
                    $dureeTotal += $module->getDuree();
                    if($dateD < $session->getDateDebut()){
                        $dateD = $session->getDateDebut();
                    }
                    if($dateF > $session->getDateFin()){
                        $dateF = $session->getDateFin();
                    }

                }
            }

            
            if($dateD > $date){
                $percent = (($date->diff($dateD)->d) + ($dateF->diff($date)->d)) / 100;

                $progression = ($date->diff($dateD)->d) / $percent;
            }

            $modules = count($modules);
            $sessions = count($sessions);

            $d = [
                'nbSession' => $sessions,
                'nbModules' => $modules,
                'duree' => $dureeTotal,
                'places' => $places,
                'progression' => $progression,
            ];

            $data []= $d;

        }

        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'formations' => $formations,
            'form' => $form->createView(),
            'data' => $data,
        ]);
    }

    #[Route('/formation/{id}', name:'show_formation')]
    public function show(Formation $formation, ManagerRegistry $doctrine, $id= null): Response
    {
        

        $sessions = $doctrine->getRepository(Session::class)->findBy(['formation' => $formation->getId()]);

        $stagiaires = [];

        foreach ($sessions as $session){
            $stagiaire = $session->getParticiper()->toArray();
            $stagiaires []= $stagiaire;
        }

        return $this->render('formation/show.html.twig',[
            'formation' => $formation,
            'sessions' => $sessions,
            'stagiaires'=> $stagiaires,
        ]);
    }


}
