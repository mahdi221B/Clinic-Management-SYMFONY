<?php

namespace App\Controller;

use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    #[Route('/blogs', name: 'app_categorie_index')]
    public function index(CategorieRepository $categorieRepository)
    {
        $categories= $categorieRepository->findAll();
        return $this->render('categorie/index.html.twig', array(
            'categories' => $categories
        ));
    }




    #[Route('/categorie', name: 'app_categorie_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, CategorieRepository $categorieRepository)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('blog_create');
        }
        return $this->renderForm('categorie/add.html.twig',array(
            'categorie' => $categorie,
            'form' => $form
        ));
    }
}
