<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle')]
    public function index(): Response
    {
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'SalleController',
        ]);
    }
    #[Route('/addSalle', name: 'app_salle_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, SalleRepository $salleRepository)
    {
        $salle = new Salle();
        $form = $this->createForm(PatientType::class, $salle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($salle);
            $em->flush();
            return $this->redirectToRoute('salle_list');
        }
        return $this->renderForm('salle/add.html.twig',array(
            'salle' => $salle,
            'form' => $form
        ));
    }

    #[Route('/salleList', name: 'salle_list')]
    public function listsalle(SalleRepository $repository)
    {
        $salle= $repository->findAll();
        return $this->render("salle/show.html.twig",array("listsalle"=>$salle));
    }


    #[Route('/delete/{id}', name: 'app_salle_delete')]
    public function deletesalle ($id,SalleRepository $repository,ManagerRegistry $managerRegistry)
    {
        $salle = $repository->find($id);
        $repository->remove($salle);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("salle_list");
    }

    #[Route('/detailsalle/{id}', name: 'app_salle2_detail')]
    public function detailmedecin($id,SalleRepository $Repository)
    {
        return $this->render('salle/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }

    #[Route('/updatesalle/{id}', name: 'update_salle')]
    public function updatesalle($id,Request $request,  PatientRepository $repository,ManagerRegistry $managerRegistry)
    {
        $salle = $repository->find($id);
        $form = $this->createForm(PatientType::class, $salle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('show_salle');
        }
        return $this->renderForm('salle/update.html.twig',array(
            'salle' => $salle,
            'form' => $form
        ));
    }

    #[Route('/alls/age/{ageMin}/{ageMax}', name: 'personne.list.age')]
    public function patientByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response {

        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findPersonnesByAgeInterval($ageMin, $ageMax);
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }
}
