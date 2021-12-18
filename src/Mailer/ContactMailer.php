<?php

namespace App\Mailer;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactMailer {

    public function __construct(MailerInterface $mailer, string $contactEmailAddress, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->contactEmailAddress = $contactEmailAddress;
        $this->twig = $twig;
    }
    
    public function sendMail(Contact $contact): void {
        $email = (new Email())
            ->from($contact->getEmail())
            ->to($this->contactEmailAddress)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Hello Symfony Mailer!')
            ->text($contact->getMessage())
            ->html('<p>Petit message de la part de ' . $contact->getFirstName() . '</p>');
        
        $this->mailer->send($email);
    }
}