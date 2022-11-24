<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use App\Repository\SponsorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontOfficeController extends AbstractController
{
    #[Route('/frontoffice', name: 'app_front_office')]
    public function frontofficeindex(): Response
    {
        return $this->render('front-office/frontindex.html.twig');
    }

    #[Route('/fronteve', name: 'app_front_eve')]
    public function fronteve(EvenementRepository $evenementRepository)
    {
        $evenements= $evenementRepository->findAll();
        return $this->render('front-office/fronteve.html.twig', array(
            'evenements' => $evenements
        ));
    }

    #[Route('/frontspon', name: 'app_front_spon')]
    public function frontspon(SponsorRepository $sponsorRepository)
    {
        $sponsors= $sponsorRepository->findAll();
        return $this->render('front-office/fontspon.html.twig', array(
            'sponsors' => $sponsors
        ));
    }
    #[Route('/backoffice', name: 'app_back_office')]
    public function backofficeindex(EvenementRepository $evenementRepository)
    {
        $totalDon = $evenementRepository->gettotalDon();
        $topEve = $evenementRepository->gettopDonName();

        return $this->render('back-office/dashbord.html.twig',array('totalDon'=>$totalDon,
            'topEve'=>$topEve
            ));
    }
}
