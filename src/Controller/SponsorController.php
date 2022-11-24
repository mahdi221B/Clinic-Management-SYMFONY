<?php

namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SponsorType;
use App\Repository\SponsorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sponsor')]
class SponsorController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_index')]
    public function index(SponsorRepository $sponsorRepository)
    {
        $sponsors= $sponsorRepository->findAll();
        return $this->render('sponsor/index.html.twig', array(
            'sponsors' => $sponsors
        ));
    }

    #[Route('/new', name: 'app_sponsor_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, SponsorRepository $sponsorRepository)
    {
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($sponsor);
            $em->flush();
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
    public function detailespon($id,SponsorRepository $Repository)
    {
        return $this->render('sponsor/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }

    #[Route('/updatesponsor/{id}', name: 'update_sponsor')]
    public function updateclassroom($id,Request $request,  SponsorRepository $repository,ManagerRegistry $managerRegistry)
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
