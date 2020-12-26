<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;

class ThreadSubscriptionsController extends Controller
{
    public function store(Channel $channel, Thread $thread)
    {
        $thread->subscribe();
    }

    public function destroy(Channel $channel, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
