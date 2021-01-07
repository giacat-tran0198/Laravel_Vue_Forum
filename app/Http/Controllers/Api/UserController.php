<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
            $this->middleware('auth')->only(['storeAva']);
    }

    public function index()
    {
        $search = request('name');
        $val = User::where('name', 'LIKE', "%$search%")
            ->take(5)
            ->pluck('name');

        return $val->map(fn($name) => ['value' => $name]);
    }

    public function storeAva(Request $request)
    {
        $request->validate( [
            'avatar' => ['required', 'image']
        ]);

        auth()->user()->update([
            'avatar_path' => $request->file('avatar')->store('avatars','public')
        ]);

        return back();
    }
}
