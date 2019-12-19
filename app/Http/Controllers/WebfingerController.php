<?php

namespace App\Http\Controllers;

use App\User;

class WebfingerController
{
    public function show()
    {
        /** @var User $user */
        $user = User::first();

        return response()->json($user->toWebfinger());
    }
}
