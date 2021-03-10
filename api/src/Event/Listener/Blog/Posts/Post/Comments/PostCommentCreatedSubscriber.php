<?php

declare(strict_types=1);

namespace App\Event\Listener\Blog\Posts\Post\Comments;

use App\Model\Blog\Entity\Posts\Post\Event\PostCommentCreated;
use App\Service\AdminUrlBuilder;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class PostCommentCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ChatterInterface $chatter,
        private AdminUrlBuilder $urlBuilder,
    ) {
    }

    #[ArrayShape([PostCommentCreated::class => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [
            PostCommentCreated::class => 'onPostCommentCreated',
        ];
    }

    public function onPostCommentCreated(PostCommentCreated $event): void
    {
        $message = <<<TEXT
        
        Добавлен новый комментарий:
        
        <b>Автор: </b> %s
        <b>Текст: </b> 
        %s

        TEXT;

        $chatMessage = new ChatMessage(
            sprintf(
                $message,
                $event->author->getName()->getFull(),
                $event->text,
            )
        );

        $telegramOptions = (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_HTML)
            ->disableWebPagePreview(true)
            ->disableNotification(true)
            ->replyMarkup((new InlineKeyboardMarkup())
                ->inlineKeyboard([
                    (new InlineKeyboardButton('Админка'))
                    ->url($this->urlBuilder->generate('blog/posts/post/comment/'.$event->id->getValue())),
                ])
            )
        ;

        $chatMessage->options($telegramOptions);

        $this->chatter->send($chatMessage);
    }
}
