<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\ResetToken;
use App\Service\FrontendUrlBuilder;
use Swift_Mailer;
use Twig\Environment;

class ResetTokenSender
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

    public function send(Email $email, ResetToken $token): void
    {
        $message = (new \Swift_Message('Подтвердите сброс пароля'))
            ->setTo($email->getValue())
            ->setFrom('no-reply@kuponopad.ru')
            ->setBody($this->twig->render('mail/user/reset.html.twig', [
                'url' => $this->urlBuilder->generate('reset/'.$token->getToken()),
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
