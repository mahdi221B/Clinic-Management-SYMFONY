<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontOfficeController extends AbstractController
{
    #[Route('/frontoffice', name: 'app_front_office')]
    public function frontofficeindex(): Response
    {
        return $this->render('front-office/index-front.html.twig');
    }

    #[Route('/backoffice', name: 'app_back_office')]
    public function backofficeindex(): Response
    {
        return $this->render('back-office/dashbord.html.twig');
    }



}