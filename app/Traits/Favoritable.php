<?php


namespace App\Traits;


use App\Models\Favorite;
use App\Models\Reply;

trait Favoritable
{

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function favorite()
    {
        if ($this->favorites()->whereUserId(auth()->id())->doesntExist()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
