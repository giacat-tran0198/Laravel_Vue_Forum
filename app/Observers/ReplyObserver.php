<?php

namespace App\Observers;

use App\Models\Reply;

class ReplyObserver
{
    /**
     * Handle the reply "created" event.
     *
     * @param  \App\Models\Reply  $reply
     * @return void
     */
    public function created(Reply $reply)
    {
        $reply->thread->increment('replies_count');
    }

    /**
     * Handle the reply "deleted" event.
     *
     * @param  \App\Models\Reply  $reply
     * @return void
     */
    public function deleted(Reply $reply)
    {
        $reply->thread->decrement('replies_count');
    }

}
