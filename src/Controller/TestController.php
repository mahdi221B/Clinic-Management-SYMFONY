<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_notyf')]
    public function index(): Response
    {
            $this->addFlash('success', 'This is a flash message.');
        return $this->render('test/index.html.twig');
    }

}
