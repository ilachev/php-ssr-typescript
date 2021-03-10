<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Email;
use App\Service\FrontendUrlBuilder;
use RuntimeException;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class SignUpConfirmTokenSender
{
    private Swift_Mailer $mailer;
    private Environment $twig;
    private FrontendUrlBuilder $urlBuilder;

    public function __construct(Swift_Mailer $mailer, Environment $twig, FrontendUrlBuilder $urlBuilder)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->urlBuilder = $urlBuilder;
    }

    public function send(Email $email, string $token): void
    {
        $message = (new Swift_Message('Подтвердите регистрацию'))
            ->setTo($email->getValue())
            ->setFrom('no-reply@kuponopad.ru')
            ->setBody($this->twig->render('mail/user/signup.html.twig', [
                'url' => $this->urlBuilder->generate('confirm/'.$token),
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new RuntimeException('Unable to send message.');
        }
    }
}
