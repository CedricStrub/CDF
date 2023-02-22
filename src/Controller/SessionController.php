<?php

namespace App\Controller;

use App\Entity\Modules;
use App\Entity\Session;
use App\Entity\Programme;
use App\Form\ModulesACType;
use App\Form\SessionAddType;
use App\Form\FormateurACType;
use App\Form\StagiaireACType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
	#[Route('/session', name: 'app_session')]
	public function index(ManagerRegistry $doctrine, Request $request): Response
	{
		$form = $this->createFormBuilder()
			->add('session', EntityType::class, [
				'class' => Session::class,
				'autocomplete' => true,
				'attr' => ['class' => 'bar']
			])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$id = $form->get('session')->getData()->getId();
			return $this->redirectToRoute('show_session',['id' => $id]);
		}


		$sessions = $doctrine->getRepository(Session::class)->findAll();

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

		return $this->render('session/index.html.twig', [
			'controller_name' => 'SessionController',
			'sessions' => $sessions,
			'data' => $data,
			'form' => $form
		]);
	}

	#[route('/session/add', name: 'add_session')]
	public function add(ManagerRegistry $doctrine, Session $session = null, Request $request)
	{
		$form = $this->createForm(SessionAddType::class, $session);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
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

	#[Route('/session/modify/{id}', name:'modify_session')]
	public function modify( ManagerRegistry $doctrine,$id, Request $request)
	{
		$session = $doctrine->getRepository(Session::class)->findOneBy(['id' => $id]);

		$formModifySession = $this->createForm(SessionAddType::class, $session);
		$formModifySession->handleRequest($request);

		if ($formModifySession->isSubmitted() && $formModifySession->isValid()) {
			$em = $doctrine->getManager();
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}
	return $this->render('session/modify.html.twig', [
		'controller_name' => 'AdministrationController',
		'formModifySession' => $formModifySession->createView(),
	]);
	}

	#[route('/session/{session}&{route}', name: 'delete_session')]
	public function remove(ManagerRegistry $doctrine,$session, $route)
	{
		$session = $doctrine->getRepository(Session::class)->findOneBy(['id' => $session]);
		
		$em = $doctrine->getManager();
		$em->remove($session);
		$em->flush();

		return $this->redirectToRoute($route, array('id' => $session->getFormation()->getId()));
	}

	#[Route('/session/{id}/remove_programme/{programmeId}&{route}', name: "remove_programme")]
	public function removeProgramme(ManagerRegistry $doctrine, int $programmeId, string $route, int $id)
	{
		$em = $doctrine->getManager();
		$programme = $em->getRepository(Programme::class)->find($programmeId);
		$em->remove($programme);
		$em->flush();
		return $this->redirectToRoute($route, ['id' => $id]);
	}

	#[route('/session/{id}', name: 'show_session')]
	public function show(ManagerRegistry $doctrine, Session $session, Request $request, $id): Response
	{
		$programmes = $doctrine->getRepository(Programme::class)->findBy(['session' => $session->getId()]);
		$stagiaires = $session->getParticiper()->toArray();
		$places = $session->getPlace();
		$placeO = count($stagiaires);
		$placeL = $places - $placeO;

		$module = new Modules;
		$formModules = $this->createForm(ModulesACType::class, $module);
		$formModules->handleRequest($request);

		if ($formModules->isSubmitted() && $formModules->isValid()) {
			$module = $formModules->get('module')->getData();
			$duree = $formModules->get('duree')->getData();

			$programme = new Programme;
			$programme->setModule($module);
			$programme->setSession($session);
			$programme->setDuree($duree);
			$em = $doctrine->getManager();
			$em->persist($programme);
			$em->flush();

			return $this->redirectToRoute('show_session', ['id' => $id]);
		}

		$stagiaireF = new Session;
		$formStagiaire = $this->createForm(StagiaireACType::class, $stagiaireF);
		$formStagiaire->handleRequest($request);

		if ($formStagiaire->isSubmitted() && $formStagiaire->isValid()) {

			$session->addParticiper($formStagiaire->getData()->getParticiper()[0]);
			$em = $doctrine->getManager();
			$em->persist($session);
			$em->flush();

			return $this->redirectToRoute('show_session', ['id' => $id]);
		}

		$formateur = $this->createForm(FormateurACType::class, $session);
		$formateur->handleRequest($request);

		if ($formateur->isSubmitted() && $formateur->isValid()) {
			$session->setFormateur($formateur->get('formateur')->getData());
			$em = $doctrine->getManager();
			$em->persist($session);
			$em->flush();
		}

		return $this->render('session/show.html.twig', [
			'session' => $session,
			'programmes' => $programmes,
			'stagiaires' => $stagiaires,
			'formFormateur' => $formateur,
			'formModulesAC' => $formModules,
			'formStagiaireAC' => $formStagiaire->createView(),
			'placeL' => $placeL,
			'nbModules' => count($programmes),
		]);
	}
}
