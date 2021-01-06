<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReplyEvent;
use App\Models\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsersListener
{
    /**
     * Handle the event.
     *
     * @param ThreadReceivedNewReplyEvent $event
     * @return void
     */
    public function handle(ThreadReceivedNewReplyEvent $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(fn(User $user) => [
                $user->notify(new YouWereMentioned($event->reply))
            ]);
    }
}
