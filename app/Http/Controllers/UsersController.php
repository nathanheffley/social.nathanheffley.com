<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserKeys;
use App\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = User::first();

        return view('home', ['user' => $user]);
    }

    public function update(StoreUserKeys $request)
    {
        auth()->user()->update($request->validated());

        return redirect('home');
    }
}
