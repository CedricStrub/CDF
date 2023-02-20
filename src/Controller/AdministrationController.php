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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

        $formFormationDelete = $this->createFormBuilder()
			->add('formation', EntityType::class, [
				'class' => Formation::class,
				'autocomplete' => true,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
			])
            ->add('submit', SubmitType::class, [
				'label' => 'Supprimer Formation',
                'attr' => ['class' => 'bouton'],
			])
			->getForm();
        $formFormationDelete->handleRequest($request);

        if ($formFormationDelete->isSubmitted() && $formFormationDelete->isValid()) {
            $id = $formFormationDelete->get('formation')->getData()->getId();
            
            return $this->redirectToRoute('delete_formation',['formation' => $id,'route' => 'app_administration']);
        }

        $formSessionDelete = $this->createFormBuilder()
			->add('session', EntityType::class, [
				'class' => Session::class,
				'autocomplete' => true,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
			])
            ->add('submit', SubmitType::class, [
				'label' => 'Supprimer Session',
                'attr' => ['class' => 'bouton'],
			])
			->getForm();
        $formSessionDelete->handleRequest($request);

        if ($formSessionDelete->isSubmitted() && $formSessionDelete->isValid()) {
            $id = $formSessionDelete->get('session')->getData()->getId();

            return $this->redirectToRoute('delete_session',['session' => $id,'route' => 'app_administration']);
        }

        $formStagiaireDelete = $this->createFormBuilder()
			->add('stagiaire', EntityType::class, [
				'class' => Stagiaire::class,
				'autocomplete' => true,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
			])
            ->add('submit', SubmitType::class, [
				'label' => 'Supprimer Stagiaire',
                'attr' => ['class' => 'bouton'],
			])
			->getForm();
        $formStagiaireDelete->handleRequest($request);

        if ($formStagiaireDelete->isSubmitted() && $formStagiaireDelete->isValid()) {
            $id = $formStagiaireDelete->get('stagiaire')->getData()->getId();

            return $this->redirectToRoute('delete_stagiaire',['stagiaire' => $id,'route' => 'app_administration']);
        }

        $formFormateurDelete = $this->createFormBuilder()
			->add('formateur', EntityType::class, [
				'class' => Formateur::class,
				'autocomplete' => true,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
			])
            ->add('submit', SubmitType::class, [
				'label' => 'Supprimer Formateur',
                'attr' => ['class' => 'bouton'],
			])
			->getForm();
        $formFormateurDelete->handleRequest($request);

        if ($formFormateurDelete->isSubmitted() && $formFormateurDelete->isValid()) {
            $id = $formFormateurDelete->get('formateur')->getData()->getId();

            return $this->redirectToRoute('delete_formateur',['formateur' => $id,'route' => 'app_administration']);
        }

        $formModulesDelete = $this->createFormBuilder()
			->add('module', EntityType::class, [
				'class' => Modules::class,
				'autocomplete' => true,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
			])
            ->add('submit', SubmitType::class, [
				'label' => 'Supprimer Module',

                'attr' => ['class' => 'bouton'],
			])
			->getForm();
        $formModulesDelete->handleRequest($request);

        if ($formModulesDelete->isSubmitted() && $formModulesDelete->isValid()) {
            $id = $formModulesDelete->get('module')->getData()->getId();

            return $this->redirectToRoute('delete_module',['module' => $id,'route' => 'app_administration']);
        }

        $formCategorieDelete = $this->createFormBuilder()
			->add('categorie', EntityType::class, [
				'class' => Categorie::class,
				'autocomplete' => true,
                'attr' => ['class' => 'input'],
                'label_attr' => [
                    'class' => 'lab',
                ],
                'row_attr' => [
                    'class' => 'wrp',
                ],
			])
            ->add('submit', SubmitType::class, [
				'label' => 'Supprimer Categorie',
                'attr' => ['class' => 'bouton'],
			])
			->getForm();
        $formCategorieDelete->handleRequest($request);

        if ($formCategorieDelete->isSubmitted() && $formCategorieDelete->isValid()) {
            $id = $formCategorieDelete->get('categorie')->getData()->getId();

            return $this->redirectToRoute('delete_categorie',['categorie' => $id,'route' => 'app_administration']);
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
            'formFormationDelete' => $formFormationDelete->createView(),
            'formSessionDelete' => $formSessionDelete->createView(),
            'formStagiaireDelete' => $formStagiaireDelete->createView(),
            'formFormateurDelete' => $formFormateurDelete->createView(),
            'formModulesDelete' => $formModulesDelete->createView(),
            'formCategorieDelete' => $formCategorieDelete->createView(),
        ]);
    }

}