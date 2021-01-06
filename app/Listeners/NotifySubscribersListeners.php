<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReplyEvent;

class NotifySubscribersListeners
{
    /**
     * Handle the event.
     *
     * @param ThreadReceivedNewReplyEvent $event
     * @return void
     */
    public function handle(ThreadReceivedNewReplyEvent $event)
    {
        $thread = $event->reply->thread;

        $thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);
    }
}
