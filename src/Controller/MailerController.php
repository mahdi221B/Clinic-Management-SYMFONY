<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(): Response
    {
        return $this->render('mailer/add.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    #[Route('/email',name: "app_sendtopfan_mail")]
    public function sendEmail(MailerInterface $mailer, CommentaireRepository $commentaireRepository): Response
    {

        $email = (new Email())
            ->from('bacem.mallek999@gmail.com')
            ->to('bacem.mallek@esprit.tn')
            ->subject('Time for Symfony Mailer!')

            ->html("<h1>Congratulation [{$commentaireRepository-> topfan()}] ! ❤ you have won a Super fan badge!️</h1>
<br> Ce badge vous permet de voir facilement les commentaires publiés par vos abonnés les plus engagés, puis d’y réagir ou d’y répondre

");

        $mailer->send($email);
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);

    }
}
