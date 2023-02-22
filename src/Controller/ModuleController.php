<?php

namespace App\Controller;

use App\Entity\Modules;
use App\Entity\Categorie;
use App\Entity\Programme;
use App\Form\ModulesAddType;
use App\Form\CategorieACType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
	#[Route('/module', name: 'app_module')]
	public function index(ManagerRegistry $doctrine, Request $request): Response
	{
		$form = $this->createFormBuilder()
			->add('module', EntityType::class, [
				'class' => Modules::class,
				'autocomplete' => true,
				'attr' => ['class' => 'bar']
			])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$id = $form->get('module')->getData()->getId();
			return $this->redirectToRoute('show_module',['id' => $id]);
		}

		$modules = $doctrine->getRepository(Modules::class)->findAll();

		return $this->render('module/index.html.twig', [
			'controller_name' => 'ModuleController',
			'modules' => $modules,
			'form' => $form
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

		$categories = $doctrine->getRepository(Categorie::class)->findAll();

		return $this->render('module/show.html.twig', [
			'controller_name' => 'ModuleController',
			'module' => $module,
			'programme' => $programme,
			'formModule' => $formModule,
			'categories' => $categories,
		]);
	}

	#[route('/module/delete/{module}&{route}', name: 'delete_module')]
	public function remove(ManagerRegistry $doctrine,$module, $route)
	{
		$module = $doctrine->getRepository(Modules::class)->findOneBy(['id' => $module]);
		
		$em = $doctrine->getManager();
		$em->remove($module);
		$em->flush();

		return $this->redirectToRoute($route);
	}

	#[Route('/module/modify/{id}', name:'modify_module')]
	public function modify( ManagerRegistry $doctrine,$id, Request $request)
	{
		$module = $doctrine->getRepository(Modules::class)->findOneBy(['id' => $id]);

		$formModifyModules = $this->createForm(ModulesAddType::class, $module);
		$formModifyModules->handleRequest($request);

		if ($formModifyModules->isSubmitted() && $formModifyModules->isValid()) {
			$em = $doctrine->getManager();
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}
	return $this->render('module/modify.html.twig', [
		'controller_name' => 'AdministrationController',
		'formModifyModules' => $formModifyModules->createView(),
	]);
	}

}
