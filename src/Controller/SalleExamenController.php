<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleExamenController extends AbstractController
{
    #[Route('/salle/examen', name: 'app_salle_examen')]
    public function index(): Response
    {
        return $this->render('salle_examen/index.html.twig', [
            'controller_name' => 'SalleExamenController',
        ]);
    }
}
