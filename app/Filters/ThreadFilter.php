<?php


namespace App\Filters;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilter extends Filter
{
    protected $filters = ['by', 'popular', 'unanswered'];

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

    /**
     * Filtrez la requête en fonction des fils les plus populaires.
     *
     * @return Builder
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderByDesc('replies_count');
    }

    /**
     * Filtrer la requête en fonction de celles sans réponse
     *
     * @return Builder
     */
    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
