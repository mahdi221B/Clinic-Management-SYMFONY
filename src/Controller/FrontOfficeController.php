<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use App\Repository\SponsorRepository;
use App\service\QrcodeService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function fronteve(Request $request,PaginatorInterface $paginator,EvenementRepository $evenementRepository)
    {
        $evenements= $evenementRepository->findAll();
            $pagination = $paginator->paginate(
            $evenements,
            $request->query->getInt('page', 1),
            3
            );
        return $this->render('front-office/fronteve.html.twig', array(
            'evenements' => $pagination
        ));
    }

    #[Route('/map', name: 'mapmap')]
    public function map()
    {
        return $this->render('sponsor/detaille.html.twig');
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
    #[Route('/qrcode/{id}', name: 'app_qr_test')]
    public function qrcode($id,QrcodeService $qrcodeService)
    {
        $qrCode = null;
        $qrCode = $qrcodeService->qrcode($id);
        return $this->render('sponsor/detaille.html.twig', array(
            'qrCode' => $qrCode,
        ));

    }

    #[Route('/meet', name: 'app_meet')]
    public function meet()
    {
        return $this->render('meet.html.twig');
    }
}
