<?php

namespace App\service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class MailerService
{

    private $mailer;

    public function __construct(MailerInterface $mailer){}

    public function sendEmail($to = 'mahdi.dridi@esprit.tn',
                              $subject = 'Test',
                              $text = 'Sending emails is fun again!',
                              $content = '<p>See Twig integration for better HTML integration!</p>')
    {
        $email = (new Email())
            ->from('iclinique10@gmail.com')
            ->to($to)
            ->subject($subject)
            ->text($text)
            ->html($content);
       $this->mailer->send($email);
    }
}