<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\MailerServices;
use App\Repository\RendezvousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RdvType;
use Doctrine\Persistence\ManagerRegistry;
use App\MailerService;
use Doctrine\Bundle\DoctrineBundle\RepositoryRendezvousRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;




use Symfony\Component\HttpFoundation\Request;

class RendezvousController extends AbstractController
{
    #[Route('/rendezvous', name: 'app_rendezvous')]
    public function index(): Response
    {
        return $this->render('rendezvous/index.html.twig', [
            'controller_name' => 'RendezvousController',
        ]);
    }
    #[Route('/rendezvousList', name: 'rendezvous')]
    public function listRendezVous(RendezvousRepository $repository)
    {
        $date = new \DateTime("now",null);
        $today = $repository->findByDate($date->format("d/m/Y"));
        $rendezvous= $repository->findAll();
        return $this->render("rendezvous/affichage.html.twig",array("listRendezvous"=>$rendezvous, "nbr"=>$today));
    }

    #[Route('/addRDV', name: 'addForm_rdv')]
    public function addForm(Request $request,ManagerRegistry $doctrine, MailerServices $mailerService,

    )
    {
        $RDV= new Rendezvous();
        $new = true;
        $form= $this->createForm(RdvType::class,$RDV);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->persist($RDV);
            $em->flush();
            if (!is_null($RDV->getEmail())){
                $message = "C linique MedTech :    Rendez-vous a été ajouté avec succès: ".$RDV->getCause()." Date: ".$RDV->getDateRDV().$RDV->getHeureRDv();

                $mailerService->sendEmail(to:$RDV->getEmail(),content:$message);
            }
            return $this->redirectToRoute("rendezvous");
        }
        return $this->renderForm("rendezvous/add.html.twig",array("form"=>$form));
    }
    #[Route('/updateFormRDV/{id}', name: 'updateForm_RDV')]
    public function updateForm($id,RendezvousRepository $repository,Request $request,ManagerRegistry $doctrine)
    {
        $RDV= $repository->find($id);
        $form= $this->createForm(RdvType::class,$RDV);
        $form->handleRequest($request) ;
        if($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("rendezvous");
        }
        return $this->renderForm("rendezvous/add.html.twig",array("form"=>$form));
    }

    #[Route('/removeFormRDV/{id}', name: 'removeForm_RDV')]
    public function removeRDV(ManagerRegistry $doctrine,$id,RendezvousRepository $repository)
    {
        $RDV= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($RDV);
        $em->flush();
        return $this->redirectToRoute("rendezvous");
    }


}
