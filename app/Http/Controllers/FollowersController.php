<?php

namespace App\Http\Controllers;

use App\Follower;
use Illuminate\Http\Request;

class FollowersController
{
    public function index(Request $request)
    {
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
