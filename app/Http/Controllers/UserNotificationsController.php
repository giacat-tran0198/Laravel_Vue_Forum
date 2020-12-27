<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserNotificationsController extends Controller
{

    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
