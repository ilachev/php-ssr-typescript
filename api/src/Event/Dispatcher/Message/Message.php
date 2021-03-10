<?php

declare(strict_types=1);

namespace App\Event\Dispatcher\Message;

class Message
{
    public function __construct(
        private object $event,
    ) {
    }

    public function getEvent(): object
    {
        return $this->event;
    }
}
