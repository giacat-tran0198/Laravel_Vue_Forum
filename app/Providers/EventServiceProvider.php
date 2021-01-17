<?php

namespace App\Providers;

use App\Events\ThreadReceivedNewReplyEvent;
use App\Listeners\NotifyMentionedUsersListener;
use App\Listeners\NotifySubscribersListeners;
use App\Listeners\NotifyThreadSubscribers;
use App\Listeners\SendEmailConfirmationRequestListenerr;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
//            SendEmailVerificationNotification::class,
            SendEmailConfirmationRequestListenerr::class,
        ],
        ThreadReceivedNewReplyEvent::class => [
            NotifyMentionedUsersListener::class,
            NotifySubscribersListeners::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
