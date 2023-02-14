<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Programme;
use App\Form\SessionACType;
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
				'placeholder' => 'Intitulé',
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


			if ($dateD > $date) {
				$percent = (($date->diff($dateD)->d) + ($dateF->diff($date)->d)) / 100;

				$progression = ($date->diff($dateD)->d) / $percent;
			}

			$modules = count($modules);
			$sessions = count($sessions);

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


		if ($dateD > $date) {
			$percent = (($date->diff($dateD)->d) + ($dateF->diff($date)->d)) / 100;

			$progression = ($date->diff($dateD)->d) / $percent;
		}

		$modulesC = count($modules);
		$sessionsC = count($sessions);

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

		$Session = new Session;;
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
