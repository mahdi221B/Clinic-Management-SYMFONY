<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\BudgetRepository;
use App\Repository\EvenementRepository;
use App\Repository\SponsorRepository;
use App\Repository\TypeEvenementRepository;
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

    #[Route('/signin', name: 'app_back_signin')]
    public function signin(): Response
    {
        return $this->render('back-office/sign-in.html.twig');
    }

    #[Route('/signup', name: 'app_back_signup')]
    public function signup(): Response
    {
        return $this->render('back-office/sign-up.html.twig');
    }

    #[Route('/fronteve', name: 'app_front_eve')]
    public function fronteve(Request $request,SponsorRepository $sponsorRepository,PaginatorInterface $paginator,EvenementRepository $evenementRepository)
    {
        $topSponors= $sponsorRepository->topSponors();
        $evenements= $evenementRepository->findAll();
            $pagination = $paginator->paginate(
            $evenements,
            $request->query->getInt('page', 1),
            3
            );
        return $this->render('front-office/fronteve.html.twig', array(
            'evenements' => $pagination,
            'topsponors' => $topSponors
        ));
    }

    #[Route('/frontevebyid/{id}', name: 'app_frontby_eve')]
    public function frontevebyid($id,Request $request,SponsorRepository $sponsorRepository,PaginatorInterface $paginator,EvenementRepository $evenementRepository)
    {
        $topSponors= $sponsorRepository->topSponors();
        $evenements= $evenementRepository->geteByTypevenet($id);
        $pagination = $paginator->paginate(
            $evenements,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('front-office/fronteve.html.twig', array(
            'evenements' => $pagination,
            'topsponors' => $topSponors
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
    #[Route('/categorie', name: 'app_front_categ')]
    public function categorie(Request $request,SponsorRepository $sponsorRepository,PaginatorInterface $paginator, TypeEvenementRepository $typeEvenementRepository)
    {
        $topSponors= $sponsorRepository->topSponors();
        $categorie= $typeEvenementRepository->findAll();
        $pagination = $paginator->paginate(
            $categorie,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('front-office/fontcate.html.twig', array(
            'categorie' => $pagination,
            'topsponors' => $topSponors
        ));
    }
    #[Route('/backoffice', name: 'app_back_office')]
    public function backofficeindex(EvenementRepository $evenementRepository,BudgetRepository $BudgetRepository)
    {
        $budget =$BudgetRepository->findAll();
        $totalDon = $evenementRepository->gettotalDon();
        $topEve = $evenementRepository->gettopDonName();

        return $this->render('back-office/dashbord.html.twig',array('totalDon'=>$totalDon,
            'topEve'=>$topEve,
            "budget"=>$budget
        ));
    }
    #[Route('/qrcode/{id}', name: 'app_qr_test')]
    public function qrcode($id,EvenementRepository $evenementRepository,QrcodeService $qrcodeService)
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
        return $this->render('evenement/detaille.html.twig', array(
            'qrCode' => $qrCode,
        ));

    }

    #[Route('/meet', name: 'app_meet')]
    public function meet()
    {
        return $this->render('meet.html.twig');
    }



}