<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Programme;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateur', name: 'app_formateur')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $formateurs = $doctrine->getRepository(Formateur::class)->findAll();

        return $this->render('formateur/index.html.twig', [
            'controller_name' => 'FormateurController',
            'formateurs' => $formateurs,
        ]);
    }

    #[route('/formateur/{id}', name: 'show_formateur')]
    public function show(ManagerRegistry $doctrine,Formateur $formateur): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findBy(['formateur' => $formateur->getId()]);
        
        $data = [];

		foreach ($sessions as $session) {
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

        return $this->render('formateur/show.html.twig', [
            'controller_name' => 'FormateurController',
            'formateur' => $formateur,
            'sessions' => $sessions,
            'data' => $data,
        ]);
    }
}
