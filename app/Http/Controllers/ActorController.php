<?php

namespace App\Http\Controllers;

use App\Note;
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

        $notes = Note::orderBy('published_at', 'DESC')->get();

        return view('actor', ['actor' => $user, 'notes' => $notes]);
    }
}
