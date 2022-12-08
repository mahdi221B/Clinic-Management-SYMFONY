<?php

namespace App\Controller;
use App\Entity\DossierPatient;

use App\Form\DossierPatientType;
use App\Service\qrcode;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\DossierPatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\QrCodeGenerator\QrCodeGenerator;


use Symfony\Component\HttpFoundation\Request;


class DossierPatientController extends AbstractController
{
    #[Route('/dossier/patient', name: 'app_dossier_patient')]
    public function index(): Response
    {
        return $this->render('dossier_patient/index.html.twig', [
            'controller_name' => 'DossierPatientController',
        ]);
    }
    #[Route('qr/{id}', name: 'app.generateQr')]
    public function generate(Request $request, DossierPatientRepository $repository)
    {
        $dossier=$repository->find($request->get('id'));
        $qr= new qrcode();
        $qr->generate($dossier);
        return $this->render("qr.html.twig", ['id'=>$dossier->getId()]);
    }
    #[Route('/dossierPatientList', name: 'dossierPatient')]
    public function listdossierPatient(DossierPatientRepository $repository)
    {
        $dossierPatient= $repository->findAll();
        return $this->render("dossier_patient/affichage.html.twig",array("listDossier"=>$dossierPatient));
    }
    #[Route('/addDossier', name: 'addForm_dossier')]
    public function addForm(Request $request,ManagerRegistry $doctrine)
    {
        $dossier= new DossierPatient();
        $form= $this->createForm(DossierPatientType::class,$dossier);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->persist($dossier);
            $em->flush();
            return $this->redirectToRoute("dossierPatient");
        }
        return $this->renderForm("dossier_patient/add.html.twig",array("form"=>$form));
    }
    #[Route('/updateFormDossier/{id}', name: 'updateForm_dossier')]
    public function updateForm($id,DossierPatientRepository $repository,Request $request,ManagerRegistry $doctrine)
    {
        $Dossier= $repository->find($id);
        $form= $this->createForm(DossierPatientType::class,$Dossier);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("dossierPatient");
        }
        return $this->renderForm("dossier_patient/add.html.twig",array("form"=>$form));
    }

    #[Route('/removeFormDossier/{id}', name: 'removeForm_dossier')]
    public function removeDossier(ManagerRegistry $doctrine,$id,DossierPatientRepository $repository)
    {
        $dossier= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($dossier);
        $em->flush();
        return $this->redirectToRoute("dossierPatient");
    }

}
