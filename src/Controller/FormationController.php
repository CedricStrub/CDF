<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Programme;
use App\Form\SessionACType;
use App\Form\FormationAddType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
			->add('formation', EntityType::class, [
				'class' => Formation::class,
				'autocomplete' => true,
				'attr' => ['class' => 'bar']
			])
			->getForm();

		$data = [];

		foreach ($formations as $formation) {
			$sessions = $doctrine->getRepository(Session::class)->findBy(['formation' => $formation->getId()]);

			$dureeTotal = 0;
			$places = 100;
			$date = new \DateTime();
			$dateD = $date;
			$dateF = $date;
			$progression = 0;
			$stagiaires = [];

			foreach ($sessions as $session) {
				$modules = $doctrine->getRepository(Programme::class)->findBy(['session' => $session->getId()]);

				$progression += $session->getStatus();
				if ($session->getPlace() < $places) {
					$places = $session->getPlace();
				}

				$stagiaire = $session->getParticiper()->toArray();
				$stagiaires[] = $stagiaire;

				foreach ($modules as $module) {
					$dureeTotal += $module->getDuree();
					if ($dateD < $session->getDateDebut()) {
						$dateD = $session->getDateDebut();
					}
					if ($dateF > $session->getDateFin()) {
						$dateF = $session->getDateFin();
					}
				}
			}

			$ctnStagiaire = $places - count($stagiaire);


			
			if($modules)
				$modules = count($modules);
			else
				$modules = 0;
			$sessions = count($sessions);

			if($progression != 0)
				$progression = $progression / $sessions;

			$d = [
				'nbSession' => $sessions,
				'nbModules' => $modules,
				'duree' => $dureeTotal,
				'placesV' => $ctnStagiaire,
				'placesT' => $places,
				'progression' => $progression,
			];

			$data[] = $d;
		}

		return $this->render('formation/index.html.twig', [
			'controller_name' => 'FormationController',
			'formations' => $formations,
			'form' => $form->createView(),
			'data' => $data,
		]);
	}

	#[Route('/formation/modify/{id}', name:'modify_formation')]
	public function modify( ManagerRegistry $doctrine,$id, Request $request)
	{
		$formation = $doctrine->getRepository(Formation::class)->findOneBy(['id' => $id]);

		$formModifyFormation = $this->createForm(FormationAddType::class, $formation);
		$formModifyFormation->handleRequest($request);

		if ($formModifyFormation->isSubmitted() && $formModifyFormation->isValid()) {
			$em = $doctrine->getManager();
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}
	return $this->render('formation/modify.html.twig', [
		'controller_name' => 'AdministrationController',
		'formModifyFormation' => $formModifyFormation->createView(),
	]);
	}

	#[route('/formation/{formation}&{route}', name: 'delete_formation')]
	public function remove(ManagerRegistry $doctrine,$formation, $route)
	{
		$formation = $doctrine->getRepository(Formation::class)->findOneBy(['id' => $formation]);
		
		$em = $doctrine->getManager();
		$em->remove($formation);
		$em->flush();

		return $this->redirectToRoute($route, array('id' => $formation->getId()));
	}


	#[Route('/formation/{id}', name: 'show_formation')]
	public function show(Formation $formation, ManagerRegistry $doctrine, $id = null, Request $request): Response
	{


		$sessions = $doctrine->getRepository(Session::class)->findBy(['formation' => $formation->getId()]);

		$dureeTotal = 0;
		$places = 100;
		$date = new \DateTime();
		$dateD = $date;
		$dateF = $date;
		$progression = 0;
		$stagiaires = [];

		foreach ($sessions as $session) {
			$modules = $doctrine->getRepository(Programme::class)->findBy(['session' => $session->getId()]);

			$progression += $session->getStatus();

			if ($session->getPlace() < $places) {
				$places = $session->getPlace();
			}

			$stagiaire = $session->getParticiper()->toArray();
			$stagiaires[] = $stagiaire;

			foreach ($modules as $module) {
				$dureeTotal += $module->getDuree();
				if ($dateD > $session->getDateDebut()) {
					$dateD = $session->getDateDebut();
				}
				if ($dateF > $session->getDateFin()) {
					$dateF = $session->getDateFin();
				}
			}
		}

		$ctnStagiaire = $places - count($stagiaire);

		$modulesC = count($modules);
		$sessionsC = count($sessions);

		if($progression != 0)
				$progression = $progression / $sessionsC;

		$data = [
			'nbSession' => $sessionsC,
			'nbModules' => $modulesC,
			'duree' => $dureeTotal,
			'dateDebut' => $dateD->format('d/m/y'),
			'dateFin' => $dateF->format('d/m/y'),
			'placesV' => $ctnStagiaire,
			'placesT' => $places,
			'progression' => $progression,
		];

		$Session = new Session;
		$formSession = $this->createForm(SessionACType::class, $Session);
		$formSession->handleRequest($request);

		if ($formSession->isSubmitted() && $formSession->isValid()) {
			$id2 = $formSession->get('intitule')->getData();
			$session = $doctrine->getRepository(Session::class)->findBy(['id' => $id2]);
			$session = $session[0];
			$formSession = $formSession->getData();

			$formSession->setIntitule($session->getIntitule());
			$formSession->setPlace($session->getPlace());
			$formSession->setDateFin($session->getDateFin());
			$formSession->setFormateur($session->getFormateur());
			$formSession->setFormation($formation);

			$em = $doctrine->getManager();
			$em->persist($formSession);
			$em->flush();

			return $this->redirectToRoute('show_formation', ['id' => $id]);
		}

		return $this->render('formation/show.html.twig', [
			'formation' => $formation,
			'sessions' => $sessions,
			'stagiaires' => $stagiaires,
			'data' => $data,
			'formSe' => $formSession->createView(),
		]);
	}
}
