<?php

namespace App;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
class MailerService
{
    public function __construct(private MailerInterface $mailer){}
    public function sendEmail(
        $to='acilazaidi@gmail.com',
            $content='<p>Bonjour, on vous informe que votre examen est prêt</p>',
            $sub='Examen prêt!'): void
    {
        $email = (new Email())
            ->from('acil.zaidi@esprit.tn')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($sub)
            //->text('Sending emails is fun again!')//
            ->html($content);

         $this->mailer->send($email);

        // ...
    }
}