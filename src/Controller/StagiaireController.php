<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
	#[Route('/stagiaire', name: 'app_stagiaire')]
	public function index(ManagerRegistry $doctrine): Response
	{
		$stagiaires = $doctrine->getRepository(Stagiaire::class)->findAll();

		return $this->render('stagiaire/index.html.twig', [
			'controller_name' => 'StagiaireController',
			'stagiaires' => $stagiaires,
		]);
	}

	#[route('/stagiaire/show/{id}', name: 'show_stagiaire')]
	public function show(ManagerRegistry $doctrine, Stagiaire $stagiaire, SessionRepository $sr): Response
	{
		$sessions = $sr->findByStagiaire($stagiaire, $doctrine);

		return $this->render('stagiaire/show.html.twig', [
			'stagiaire' => $stagiaire,
			'sessions' => $sessions
		]);
	}

	#[Route('/stagiaire/{stagiaire}&{session}&{route}&{id}', name: 'remove_stagiaire')]
	public function remove(ManagerRegistry $doctrine, Stagiaire $stagiaire, Session $session, $route, $id)
	{
		$em = $doctrine->getManager();
		$session = $em->getRepository(Session::class)->find($session->getId());
		$session->removeParticiper($stagiaire);
		$em->flush();

		return $this->redirectToRoute($route, ['id' => $id]);
	}

	#[Route('/stagiaire/{id}', name: 'delete_stagiaire')]
	public function delete(ManagerRegistry $doctrine, $stagiaire)
	{
		$em = $doctrine->getManager();
		$stagiaire = $em->getRepository(Stagiaire::class)->find($stagiaire);
		if ($stagiaire) {
			$em->remove($stagiaire);
		}
		$em->flush();
	}
}
