<?php

namespace App\Observers;


use App\Models\Thread;

class ThreadObserver
{
    /**
     * Handle the thread "created" event.
     *
     * @param Thread $thread
     * @return void
     */
    public function created(Thread $thread)
    {
        $thread->update(['slug' => $thread->title]);
    }

    /**
     * Handle the thread "deleting" event.
     *
     * @param Thread $thread
     * @return void
     */
    public function deleting(Thread $thread)
    {
        $thread->replies->each->delete();
    }

}
