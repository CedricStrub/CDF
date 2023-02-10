<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Programme;
use App\Form\SessionACType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();

        $data = [];
        
        foreach($sessions as $session){
            $modules = $doctrine->getRepository(Programme::class)->findBy(['session' => $session->getId()]);
            $places = $session->getPlace();
            $stagiaire = $session->getParticiper()->toArray();
            $placeO = count($stagiaire);
            $placeL = $places - $placeO;

            $d = [
                'intitule' => $session->getIntitule(),
                'dateDebut' => $session->getDateDebut(),
                'dateFin' => $session->getDateFin(),
                'placeL' => $placeL,
                'place' => $places,
            ];

            $data[] = $d;

        }

        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'sessions' => $sessions,
            'data' => $data,
        ]);
    }

    #[route('/session/add', name:'add_session')]
    public function add(ManagerRegistry $doctrine, Session $session = null, Request $request)
    {
        $form = $this->createForm(SessionACType::class, $session);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $session = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($session);
            $em->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/add.html.twig', [
            'formAddSession' => $form->createView()
        ]);
    }

    #[route('/session/{session}&{route}', name:'remove_session')]
    public function remove(ManagerRegistry $doctrine,Session $session, $route)
    {
        //$em = $doctrine->getManager();
        //$em->remove($session);
        //$em->flush();
        return $this->redirectToRoute($route, array('id' => $session->getFormation()->getId()));
    }

    #[route('/session/{id}', name:'show_session')]
    public function show(ManagerRegistry $doctrine, Session $session): Response
    {
        $programmes = $doctrine->getRepository(Programme::class)->findBy(['session' => $session->getId()]);
        $stagiaires = $session->getParticiper()->toArray();
        $places = $session->getPlace();
        $placeO = count($stagiaires);
        $placeL = $places - $placeO;

        return $this->render('session/show.html.twig',[
            'session' => $session,
            'programmes' => $programmes,
            'stagiaires' => $stagiaires,
            'placeL' => $placeL,
            'nbModules' => count($programmes),
        ]);
    }

}
