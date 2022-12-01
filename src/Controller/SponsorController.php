<?php

namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SponsorType;
use App\Repository\SponsorRepository;
use App\service\PdfService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/sponsor')]
class SponsorController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_index')]
    public function index(Request $request,PaginatorInterface $paginator,SponsorRepository $sponsorRepository)
    {
        $sponsors= $sponsorRepository->findAll();
        $pagination = $paginator->paginate(
            $sponsors,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('sponsor/index.html.twig', array(
            'sponsors' => $pagination
        ));
    }

    #[Route('/new', name: 'app_sponsor_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry,MailerInterface $mailer,PdfService $pdfService, SponsorRepository $sponsorRepository)
    {
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor);
        //form essay d'analyse la requete que jai suoumiss et il va analyser afin de voir est ce que
        // elle a ete souimis ou pas et est ce que tous les champ remplis ou pas
        //et kol chmap yel9ah il va le bindé avec le champ dans variable $sponsor
        $form->handleRequest($request);
        //dd($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($sponsor);
            $em->flush();
            //mail
            $email = (new Email())
                ->from('iclinique10@gmail.com')
                ->to('mahdi209208@gmail.com')
                ->subject($sponsor->getNomSociete())
                ->text('Sending emails is fun again!')
                ->html($sponsor->getTypeSponsoring());
            $mailer->send($email);
            //$this->addFlash('success', 'Sponsor ajouté avec succ');
            return $this->redirectToRoute('app_sponsor_index');

        }
        return $this->renderForm('sponsor/add.html.twig',array(
            'sponsor' => $sponsor,
            'form' => $form
        ));
    }

    #[Route('/{id}', name: 'app_sponsor_delete')]
    public function deletesponsor($id,SponsorRepository $sponsorRepository,ManagerRegistry $managerRegistry)
    {
        $sponsor = $sponsorRepository->find($id);
        $sponsorRepository->remove($sponsor);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("app_sponsor_index");
    }

    #[Route('/detailSpon/{id}', name: 'app_spon_detail')]
    public function detailespon($id,SponsorRepository $Repository,PdfService $pdfService)
    {
        return $this->render('sponsor/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }

    #[Route('/updatesponsor/{id}', name: 'update_sponsor')]
    public function updatesponsor($id,Request $request,  SponsorRepository $repository,ManagerRegistry $managerRegistry)
    {
        $sponsor = $repository->find($id);
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('app_sponsor_index');
        }
        return $this->renderForm('sponsor/update.html.twig',array(
            'sponsor' => $sponsor,
            'form' => $form
        ));
    }

}
