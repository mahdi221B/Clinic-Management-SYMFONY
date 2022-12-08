<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use App\Form\MedecinType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;



class MedecinController extends AbstractController
{
    #[Route('/medecin', name: 'app_medecin_index')]
    public function index(): Response
    {
        return $this->render('medecin/index.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }


    #[Route('/new', name: 'app_medecin_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, MedecinRepository $medecinRepository)
    {
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($medecin);
            $em->flush();
            return $this->redirectToRoute('medecin_list');
        }
        return $this->renderForm('medecin/add.html.twig',array(
            'medecin' => $medecin,
            'form' => $form
        ));
    }

    #[Route('/medecinList', name: 'medecin_list')]
    public function listmedecin(MedecinRepository $repository)
    {
        $medecin= $repository->findAll();
        return $this->render("medecin/show.html.twig",array("listmedecin"=>$medecin));
    }


    #[Route('medcin/delete/{id}', name: 'app_medecin_delete')]
    public function deletemed ($id,MedecinRepository $repository,ManagerRegistry $managerRegistry)
    {
        $medecin = $repository->find($id);
        $repository->remove($medecin);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("medecin_list");
    }

    #[Route('/detailmed/{id}', name: 'app_medecin2_detail')]
    public function detailmedecin($id,MedecinRepository $Repository)
    {
        return $this->render('medecin/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }

    #[Route('/updatemedecin/{id}', name: 'update_medecin')]
    public function updatemedecin($id,Request $request,  MedecinRepository $repository,ManagerRegistry $managerRegistry)
    {
        $medecin = $repository->find($id);
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('show_medecin');
        }
        return $this->renderForm('medecin/update.html.twig',array(
            'medecin' => $medecin,
            'form' => $form
        ));
    }
}
