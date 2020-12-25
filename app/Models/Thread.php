<?php

namespace App\Models;

use App\Filters\ThreadFilter;
use App\Observers\ThreadObserver;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $activitiesToRecord = ['created'];

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::observe(ThreadObserver::class);
    }


    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, ThreadFilter $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe(?int $userId = null)
    {
        $this->subscription()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);
    }

    public function unsubscribe(?int $userId = null)
    {
        $this->subscription()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscription()
    {
        return $this->hasMany(ThreadSubscription::class);
    }
}
