<?php


namespace App\Filters;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilter extends Filter
{
    protected $filters = ['by'];

    /**
     * Filtrer la requête par un nom d'utilisateur
     *
     * @param string $username
     * @return Builder
     */
    protected function by(string $username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
