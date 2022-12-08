<?php

namespace App\Controller;

use App\Entity\SalleExamen;
use App\Form\SalleExamenType;
use App\Repository\SalleExamenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleExamenController extends AbstractController
{
    #[Route('/salle/examen', name: 'app_salle_examen')]
    public function index(): Response
    {
        return $this->render('salle_examen/index.html.twig', [
            'controller_name' => 'SalleExamenController',
        ]);
    }
    #[Route('/addSalleExamen', name: 'app_salleexamen_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, SalleExamenRepository $salleExamenRepository)
    {
        $salleexamen = new SalleExamen();
        $form = $this->createForm(SalleExamenType::class, $salleexamen);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($salleexamen);
            $em->flush();
            return $this->redirectToRoute('salle_examen_list');
        }
        return $this->renderForm('salle_examen/add.html.twig',array(
            'salleexamen' => $salleexamen,
            'form' => $form
        ));
    }

    #[Route('/salle_examen_List', name: 'salle_examen_list')]
    public function listsalleexamen(SalleExamenRepository $repository)
    {
        $salleexamen= $repository->findAll();
        return $this->render("salle_examen/show.html.twig",array("list_salle_examen"=>$salleexamen));
    }


    #[Route('/delete_salle_examen/{id}', name: 'app_salle_examen_delete')]
    public function deletesalleexamen ($id,SalleExamenRepository $repository,ManagerRegistry $managerRegistry)
    {
        $salleexamen = $repository->find($id);
        $repository->remove($salleexamen);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("salle_examen_list");
    }


    #[Route('/update_salle_examen/{id}', name: 'update_salle_examen')]
    public function updatesalleexamen($id,Request $request,  SalleExamenRepository $repository,ManagerRegistry $managerRegistry)
    {
        $salleexamen = $repository->find($id);
        $form = $this->createForm(SalleExamenType::class, $salleexamen);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('salle_examen_list');
        }
        return $this->renderForm('salle_examen/update.html.twig',array(
            'salle_examen' => $salleexamen,
            'form' => $form
        ));
    }
}
