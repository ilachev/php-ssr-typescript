<?php

declare(strict_types=1);

namespace App\Event\Listener\User;

use App\Model\User\Entity\User\Event\UserConfirmed;
use App\Service\AdminUrlBuilder;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class UserConfirmSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ChatterInterface $chatter,
        private AdminUrlBuilder $urlBuilder,
    ) {
    }

    #[ArrayShape([UserConfirmed::class => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [
            UserConfirmed::class => 'onUserConfirmed',
        ];
    }

    public function onUserConfirmed(UserConfirmed $event): void
    {
        $chatMessage = new ChatMessage(
            sprintf('
Зарегистрирован новый пользователь
*Зовут*: %s
*Email*: %s
            ',
                $event->fullName,
                $event->email,
            )
        );

        $telegramOptions = (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_MARKDOWN)
            ->disableWebPagePreview(true)
            ->disableNotification(true)
            ->replyMarkup((new InlineKeyboardMarkup())
                ->inlineKeyboard([
                    (new InlineKeyboardButton('Ссылка на пользователя'))
                        ->url($this->urlBuilder->generate('users/'.$event->id->getValue())),
                ])
            );

        $chatMessage->options($telegramOptions);

        $this->chatter->send($chatMessage);
    }
}
