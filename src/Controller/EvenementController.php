<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\SponsorRepository;
use App\service\PdfService;
use App\service\QrcodeService;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/testchart', name: 'app_evenement_chart')]
    public function chart(Request $request,SponsorRepository $sponsorRepository,EvenementRepository $evenementRepository)
    {
        $evenements= $evenementRepository->getMonByTyev();
        dd($evenements);
    }
    #[Route('/', name: 'app_evenement_index')]
    public function index(Request $request,PaginatorInterface $paginator,SponsorRepository $sponsorRepository,EvenementRepository $evenementRepository)
    {
        $evenements= $evenementRepository->findAll();
        $pagination = $paginator->paginate(
            $evenements,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('evenement/index.html.twig', array(
            'evenements' => $pagination
        ));
    }

    #[Route('/new', name: 'app_evenement_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, EvenementRepository $evenementRepository)
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image= $request -> files->get ('evenement')['picture'];
            $uploads_directory= $this->getParameter('uploads_directory');
            $filename =md5(uniqid()) . '.' . $image ->guessExtension();
            $image ->move(
                $uploads_directory,
                $filename
            );
            $evenement->setPicture($filename);
            $evenement->setMontantRecole(0);
            $em = $managerRegistry->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('app_evenement_index');
        }
        return $this->renderForm('evenement/add.html.twig',array(
            'evenement' => $evenement,
            'form' => $form
        ));
    }

    #[Route('/{id}', name: 'app_evenement_delete')]
    public function deleteevent ($id,EvenementRepository $repository,ManagerRegistry $managerRegistry)
    {
        $classroom = $repository->find($id);
        $repository->remove($classroom);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("app_evenement_index");
    }

    #[Route('/detailEve/{id}', name: 'app_evenement2_detail')]
    public function detailtypeevenement($id,EvenementRepository $Repository)
    {
        return $this->render('evenement/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }

    #[Route('/updateEvenement/{id}', name: 'update_evenement')]
    public function updateclassroom($id,Request $request,  EvenementRepository $repository,ManagerRegistry $managerRegistry)
    {
        $evenement = $repository->find($id);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('app_evenement_index');
        }
        return $this->renderForm('evenement/update.html.twig',array(
            'evenement' => $evenement,
            'form' => $form
        ));
    }



    #[Route('/detailEventfront/{id}', name: 'app_eveFront_detail')]
    public function detailespon($id,EvenementRepository $evenementRepository,PdfService $pdfService, QrcodeService $qrcodeService)
    {
        $evenement = $evenementRepository->find($id);
        $content = "
        Event : ".$evenement->getTitre()."
        ".
            "Description : ".$evenement->getDescription()."
            ".
            "Date début : ".$evenement->getDateDebut()."
            ".
            "Date fin".$evenement->getDateFin()."
            ".
            "lieu : ".$evenement->getLieu()."
            ".
            "Nom organisateur".$evenement->getNomOrganisateur()."
            ".
            "téléphone : ".$evenement->getPhoneOrganisateur()."
            ".
            "E-mail".$evenement->getEmailOrganisateur()."
            "
        ;
        $qrCode = null;
        $qrCode = $qrcodeService->qrcode($content);
        $html = $this->render('evenement/pdf.html.twig',array(
            'i' => $evenement,
            'qrCode' => $qrCode
        ));
        $pdfService->showPdfFile($html);
        return $html;
    }



}