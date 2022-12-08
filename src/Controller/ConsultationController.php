<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use ContainerCJVvb1D\getConsultationControllerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;




class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'app_consultation')]
    public function index(): Response
    {
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }
    #[Route('/detailcons/{id}', name: 'app_cons_detail')]
    public function detailtypeconsultation($id,ConsultationRepository $Repository)
    {
        return $this->render('consultation/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }



    #[Route('/consultationList', name: 'consultation')]
    public function listConsultation(ConsultationRepository $repository)
    {
        $consultation= $repository->findAll();
        return $this->render("consultation/affichage.html.twig",array("listConsultation"=>$consultation));
    }

    #[Route('/addForm', name: 'addForm_consultation')]
    public function addForm(Request $request,ManagerRegistry $doctrine)
    {
        $consultation= new Consultation();
        $form= $this->createForm(ConsultationType::class,$consultation);
        $form->handleRequest($request) ;
        if($form->isSubmitted()&&$form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($consultation);
            $em->flush();
            return $this->redirectToRoute("consultation");
        }
        return $this->renderForm("consultation/add.html.twig",array("form"=>$form));
    }

    #[Route('/updateFormCons/{id}', name: 'updateForm_consultation')]
    public function updateForm($id,ConsultationRepository $repository,Request $request,ManagerRegistry $doctrine)
    {
        $Consultation= $repository->find($id);
        $form= $this->createForm(ConsultationType::class,$Consultation);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("consultation");
        }
        return $this->renderForm("consultation/add.html.twig",array("form"=>$form));
    }
    #[Route('/removeFormConsultation/{id}', name: 'removeForm_consultation')]
    public function removeConsultation(ManagerRegistry $doctrine,$id,ConsultationRepository $repository)
    {
        $consultation= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($consultation);
        $em->flush();
        return $this->redirectToRoute("consultation");
    }
    #[Route('/pdf', name: 'consultation.pdf')]
    public function generatePdfPersonne(Request $request, ConsultationRepository $consultationRepository) {
        $req = $request->getQueryString();
        $id = substr($req,3);
        $consultation = $consultationRepository->find($id);


        $html = $this->render('template.html.twig',[
            'consultation' => $consultation
        ]);
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4');
        $dompdf->render();

        // $name = 'attestation'
        ob_get_clean();
        $name = "consultation::".$consultation->getId().".pdf";
        $dompdf->stream($name);

    }




}
