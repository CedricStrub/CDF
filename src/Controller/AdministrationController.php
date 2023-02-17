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
use App\Form\ModulesModifyType;
use App\Form\SessionModifyType;
use App\Form\CategorieModifyType;
use App\Form\FormateurModifyType;
use App\Form\FormationModifyType;
use App\Form\StagiaireModifyType;
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

        $formation = new Formation;
        $formFormation = $this->createForm(FormationModifyType::class, $formation);
        $formFormation->handleRequest($request);

        if ($formFormation->isSubmitted() && $formFormation->isValid()) {
            $id = $formFormation->get('intitule')->getData();
            
            return $this->redirectToRoute('modify_formation',['id' => $id]);
        }

        $session = new Session;
        $formSession = $this->createForm(SessionModifyType::class, $session);
        $formSession->handleRequest($request);

        if ($formSession->isSubmitted() && $formSession->isValid()) {
            $id = $formSession->get('intitule')->getData();
            
            return $this->redirectToRoute('modify_session',['id' => $id]);
        }

        $stagiaire = new Stagiaire;
        $formStagiaire = $this->createForm(StagiaireModifyType::class, $stagiaire);
        $formStagiaire->handleRequest($request);

        if ($formStagiaire->isSubmitted() && $formStagiaire->isValid()) {
            $id = $formStagiaire->get('nom')->getData();
            
            return $this->redirectToRoute('modify_stagiaire',['id' => $id]);
        }

        $formateur = new Formateur;
        $formFormateur = $this->createForm(FormateurModifyType::class, $formateur);
        $formFormateur->handleRequest($request);

        if ($formFormateur->isSubmitted() && $formFormateur->isValid()) {
            $id = $formFormateur->get('nom')->getData();
            
            return $this->redirectToRoute('modify_formateur',['id' => $id]);
        }

        $modules = new Modules;
        $formModules = $this->createForm(ModulesModifyType::class, $modules);
        $formModules->handleRequest($request);

        if ($formModules->isSubmitted() && $formModules->isValid()) {
            $id = $formModules->get('nom')->getData();
            
            return $this->redirectToRoute('modify_module',['id' => $id]);
        }

        $categorie = new Categorie;
        $formCategorie = $this->createForm(CategorieModifyType::class, $categorie);
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
            $id = $formCategorie->get('nom')->getData();
            
            return $this->redirectToRoute('modify_categorie',['id' => $id]);
        }


        return $this->render('administration/index.html.twig', [
            'controller_name' => 'AdministrationController',
            'formAddSession' => $formAddSession->createView(),
            'formAddCategorie' => $formAddCategorie->createView(),
            'formAddFormateur' => $formAddFormateur->createView(),
            'formAddFormation' => $formAddFormation->createView(),
            'formAddModules' => $formAddModules->createView(),
            'formAddStagiaire' => $formAddStagiaire->createView(),
            'formFormation' => $formFormation->createView(),
            'formSession' => $formSession->createView(),
            'formStagiaire' => $formStagiaire->createView(),
            'formFormateur' => $formFormateur->createView(),
            'formModules' => $formModules->createView(),
            'formCategorie' => $formCategorie->createView(),
        ]);
    }

}