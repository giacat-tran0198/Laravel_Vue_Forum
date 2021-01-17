<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))->first();
        if (! $user) {
            return redirect(route('threads'))->with('flash', 'Token inconnu.');
        }
        $user->confirm();

        return redirect(route('threads'))
            ->with('flash', 'Votre compte est maintenant confirmé! Vous pouvez publier sur le forum.');
    }
}
