<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(): Response
    {
        return $this->render('stagiaire/index.html.twig', [
            'controller_name' => 'StagiaireController',
        ]);
    }

    #[Route('/stagiaire/{stagiaire}&{session}&{route}', name: 'remove_stagiaire')]
    public function remove(ManagerRegistry $doctrine,Stagiaire $stagiaire,Session $session, $route)
    {
        $em = $doctrine->getManager();
        $session->removeParticiper($stagiaire);
        $em->flush();

        return $this->redirectToRoute($route, array('id' => $session->getFormation()->getId()));
    }

}
