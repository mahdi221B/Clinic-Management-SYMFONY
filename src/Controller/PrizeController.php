<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrizeController extends AbstractController
{
    #[Route('/prize', name: 'app_prize')]
    public function index(): Response
    {
        return $this->render('prize/index.html.twig', [
            'controller_name' => 'PrizeController',
        ]);
    }
}
