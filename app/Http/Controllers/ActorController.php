<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ActorController
{
    public function show(Request $request)
    {
        $actor = User::first();

        if ($request->wantsJson()) {
            return response()->json([
                '@context' => [
                    'https://www.w3.org/ns/activitystreams',
                    'https://w3id.org/security/v1',
                ],

                'id' => route('actor'),
                'type' => 'Person',
                'preferredUsername' => $actor->preferred_username,
                'inbox' => route('inbox'),

                'publicKey' => [
                    'id' => route('actor') . '#public-key',
                    'owner' => route('actor'),
                    'publicKeyPem' => '',
                ],
            ]);
        }

        return view('actor', ['actor' => $actor]);
    }
}
