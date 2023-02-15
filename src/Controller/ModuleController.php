<?php

namespace App\Controller;

use App\Entity\Modules;
use App\Entity\Categorie;
use App\Entity\Programme;
use App\Form\CategorieACType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
	#[Route('/module', name: 'app_module')]
	public function index(ManagerRegistry $doctrine): Response
	{
		$modules = $doctrine->getRepository(Modules::class)->findAll();

		return $this->render('module/index.html.twig', [
			'controller_name' => 'ModuleController',
			'modules' => $modules,
		]);
	}

	#[Route('/module/{id}', name: 'show_module')]
	public function show(ManagerRegistry $doctrine,Modules $module, Request $request): Response
	{
		$programme = $doctrine->getRepository(Programme::class)->findBy(['module' => $module->getId()]);

		$categorie = new Modules;
		$formModule = $this->createForm(CategorieACType::class, $categorie);
		$formModule->handleRequest($request);

		if ($formModule->isSubmitted() && $formModule->isValid()) {
			$module->setCategorie($formModule->get('categorie')->getData());

			$em = $doctrine->getManager();
			$em->persist($module);
			$em->flush();

			return $this->redirectToRoute('show_module', ['id' => $module->getId()]);
		}

		$modules = $doctrine->getRepository(Modules::class)->findAll();

		return $this->render('module/show.html.twig', [
			'controller_name' => 'ModuleController',
			'module' => $module,
			'programme' => $programme,
			'formModule' => $formModule,
			'modules' => $modules,
		]);
	}

}
