<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formateur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{

    #[Route('/profil', name: 'app_profil')]
    public function index(ManagerRegistry $doctrine,Security $security): Response
    {
        $user = $security->getUser();
        $formateur = $doctrine->getRepository(Formateur::class)->findOneBy(['email' => $user->getEmail()]);
        $sessions = $doctrine->getRepository(Session::class)->findBy(['formateur' => $formateur->getId()]);

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'utilisateur' => $formateur,
            'sessions' => $sessions,
        ]);
    }

}