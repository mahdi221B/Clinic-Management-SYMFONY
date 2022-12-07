<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\CommentaireRepository;
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
    public function sendEmail2(MailerInterface $mailer, CommentaireRepository $commentaireRepository): Response
    {
        $email = (new Email())
            ->from('bacem.mallek999@gmail.com')
            ->to('bacem.mallek@esprit.tn')
            ->subject('Time for Symfony Mailer!')

            ->html("<h1>Congratulation [{$commentaireRepository-> topfan()}] ! ❤ you have won a Super fan badge!️</h1>
                   <br> Ce badge vous permet de voir facilement les commentaires publiés par vos abonnés les plus engagés, puis d’y réagir ou d’y répondre");
        $mailer->send($email);
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('iclinique10@gmail.com')
            ->to('mahdi209208@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        $mailer->send($email);
        return $this->renderForm('back-office/index-back.html.twig');
    }

    #[Route('/email3')]
    public function sendEmail3(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('acil.zaidi@esprit.tn')
            ->to('acilazaidi@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        $mailer->send($email);
        return $this->renderForm('back-office/index-back.html.twig');
    }
}
