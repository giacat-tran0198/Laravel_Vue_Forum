<?php


namespace App\Traits;


use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model){
            $model->favorites->each->delete();
        });
    }


    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function isFavorited()
    {
        return !!$this->favorites()->whereUserId(auth()->id())->count();
    }

    public function favorite()
    {
        if ($this->favorites()->whereUserId(auth()->id())->doesntExist()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function unfavorite()
    {
        $this->favorites()->whereUserId(auth()->id())->get()->each->delete();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
