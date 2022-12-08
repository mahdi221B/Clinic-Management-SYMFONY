<?php

namespace App\Controller;

use App\service\qrcode;
use App\service\QrcodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontofficeController extends AbstractController
{
    #[Route('/frontoffice', name: 'app_frontoffice')]
    public function index(): Response
    {
        return $this->render('frontoffice/index.html.twig', [
            'controller_name' => 'FrontofficeController',
        ]);
    }
    #[Route('/backoffice', name: 'app_back_office')]
    public function backofficeindex(): Response
    {
        return $this->render('back-office/dashbord.html.twig');
    }
    #[Route('/qrcode/{id}', name: 'app_qr_test')]
    public function qrcode($id,qrcode $qrcodeService)
    {
        $qrCode = null;
        $qrCode = $qrcodeService->qrcode($id);
        return $this->render('dossier_patient/detaille.html.twig', array(
            'qrCode' => $qrCode,
        ));
}}
