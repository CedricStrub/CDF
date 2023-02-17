<?php

namespace App\Controller;

use App\Entity\Modules;
use App\Entity\Session;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use App\Form\ModulesAddType;
use App\Form\SessionAddType;
use App\Form\CategorieAddType;
use App\Form\FormateurAddType;
use App\Form\FormationAddType;
use App\Form\StagiaireAddType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdministrationController extends AbstractController
{

    #[Route('/administration', name: 'app_administration')]
    public function index(ManagerRegistry $doctrine, Session $session = null, Categorie $categorie = null, Formateur $formateur = null, Formation $formation = null, Modules $modules = null, Stagiaire $stagiaire = null, Request $request): Response
    {
        $formAddSession = $this->createForm(SessionAddType::class, $session);
		$formAddSession->handleRequest($request);

		if ($formAddSession->isSubmitted() && $formAddSession->isValid()) {
			$session = $formAddSession->getData();
			$em = $doctrine->getManager();
			$em->persist($session);
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}

        $formAddCategorie = $this->createForm(CategorieAddType::class, $categorie);
		$formAddCategorie->handleRequest($request);

		if ($formAddCategorie->isSubmitted() && $formAddCategorie->isValid()) {
			$categorie = $formAddCategorie->getData();
			$em = $doctrine->getManager();
			$em->persist($categorie);
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}

        $formAddFormateur = $this->createForm(FormateurAddType::class, $formateur);
		$formAddFormateur->handleRequest($request);

		if ($formAddFormateur->isSubmitted() && $formAddFormateur->isValid()) {
			$formateur = $formAddFormateur->getData();
			$em = $doctrine->getManager();
			$em->persist($formateur);
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}

        $formAddFormation = $this->createForm(FormationAddType::class, $formation);
		$formAddFormation->handleRequest($request);

		if ($formAddFormation->isSubmitted() && $formAddFormation->isValid()) {
			$formation = $formAddFormation->getData();
			$em = $doctrine->getManager();
			$em->persist($formation);
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}

        $formAddModules = $this->createForm(ModulesAddType::class, $modules);
		$formAddModules->handleRequest($request);

		if ($formAddModules->isSubmitted() && $formAddModules->isValid()) {
			$modules = $formAddModules->getData();
			$em = $doctrine->getManager();
			$em->persist($modules);
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}

        $formAddStagiaire = $this->createForm(StagiaireAddType::class, $stagiaire);
		$formAddStagiaire->handleRequest($request);

		if ($formAddStagiaire->isSubmitted() && $formAddStagiaire->isValid()) {
			$stagiaire = $formAddStagiaire->getData();
			$em = $doctrine->getManager();
			$em->persist($stagiaire);
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}

        return $this->render('administration/index.html.twig', [
            'controller_name' => 'AdministrationController',
            'formAddSession' => $formAddSession->createView(),
            'formAddCategorie' => $formAddCategorie->createView(),
            'formAddFormateur' => $formAddFormateur->createView(),
            'formAddFormation' => $formAddFormation->createView(),
            'formAddModules' => $formAddModules->createView(),
            'formAddStagiaire' => $formAddStagiaire->createView(),
        ]);
    }

}