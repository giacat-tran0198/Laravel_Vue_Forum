<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfEmailNotConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->confirmed) {
            return redirect(route('threads.index'))
                ->with('flash', "Vous devez d'abord confirmer votre adresse e-mail.");
        }
        return $next($request);
    }
}
