<?php

namespace App\Http\Controllers;

use App\Follower;
use App\User;
use Illuminate\Http\Request;

class FollowersController
{
    public function index(Request $request)
    {
        if (!$request->wantsJson()) {
            $user = User::first();
            $followers = Follower::orderBy('created_at', 'ASC')->get();

            return view('followers', ['actor' => $user, 'followers' => $followers]);
        }

        $route = route('actor') . '/followers';

        $followers = Follower::orderBy('created_at', 'ASC')->get();

        if ($request->get('page')) {
            return response()->json([
                '@context' => 'https://www.w3.org/ns/activitystreams',
                'id' => $route . '?page=1',
                'type' => 'OrderedCollectionPage',
                'totalItems' => $followers->count(),
                'partOf' => $route,
                'orderedItems' => $followers->pluck('actor'),
            ]);
        } else {
            return response()->json([
                '@context' => 'https://www.w3.org/ns/activitystreams',
                'id' => $route,
                'type' => 'OrderedCollection',
                'totalItems' => $followers->count(),
                'first' => $route . '?page=1',
            ]);
        }
    }
}
