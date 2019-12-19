<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ActorController
{
    public function show(Request $request)
    {
        /** @var User $user */
        $user = User::first();

        if ($request->wantsJson()) {
            return response()->json($user->toActor());
        }

        return view('actor', ['actor' => $user]);
    }
}
