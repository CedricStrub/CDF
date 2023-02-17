<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieAddType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/modify/{id}', name:'modify_categorie')]
	public function modify( ManagerRegistry $doctrine,$id, Request $request)
	{
		$categorie = $doctrine->getRepository(Categorie::class)->findOneBy(['id' => $id]);

		$formModifyCategorie = $this->createForm(CategorieAddType::class, $categorie);
		$formModifyCategorie->handleRequest($request);

		if ($formModifyCategorie->isSubmitted() && $formModifyCategorie->isValid()) {
			$em = $doctrine->getManager();
			$em->flush();

			return $this->redirectToRoute('app_administration');
		}
	return $this->render('categorie/modify.html.twig', [
		'controller_name' => 'AdministrationController',
		'formModifyCategorie' => $formModifyCategorie->createView(),
	]);
	}
}
