<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Programme;
use App\Form\FormateurAddType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateur', name: 'app_formateur')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
		$form = $this->createFormBuilder()
			->add('formateur', EntityType::class, [
				'class' => Formateur::class,
				'autocomplete' => true,
				'attr' => ['class' => 'bar']
			])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$id = $form->get('formateur')->getData()->getId();
			return $this->redirectToRoute('show_formateur',['id' => $id]);
		}

        $formateurs = $doctrine->getRepository(Formateur::class)->findAll();

        return $this->render('formateur/index.html.twig', [
            'controller_name' => 'FormateurController',
            'formateurs' => $formateurs,
			'form' => $form,
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

	#[route('/formateur/delete/{formateur}&{route}', name: 'delete_formateur')]
	public function remove(ManagerRegistry $doctrine,$formateur, $route)
	{
		$formateur = $doctrine->getRepository(Formateur::class)->findOneBy(['id' => $formateur]);
		
		$em = $doctrine->getManager();
		$em->remove($formateur);
		$em->flush();

		return $this->redirectToRoute($route);
	}

    #[Route('/formateur/modify/{id}', name:'modify_formateur')]
	public function modify( ManagerRegistry $doctrine,$id, Request $request)
	{
		$formateur = $doctrine->getRepository(Formateur::class)->findOneBy(['id' => $id]);

		$formModifyFormateur = $this->createForm(FormateurAddType::class, $formateur);
		$formModifyFormateur->handleRequest($request);

		if ($formModifyFormateur->isSubmitted() && $formModifyFormateur->isValid()) {
			$em = $doctrine->getManager();
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}
	return $this->render('formateur/modify.html.twig', [
		'controller_name' => 'AdministrationController',
		'formModifyFormateur' => $formModifyFormateur->createView(),
	]);
	}
}
