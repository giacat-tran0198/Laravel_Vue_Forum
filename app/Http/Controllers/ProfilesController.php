<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Response;

class ProfilesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $profileUser
     * @return Response
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user),
        ]);
    }
}
