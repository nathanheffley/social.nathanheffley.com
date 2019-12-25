<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class OutboxController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->wantsJson()) {
            abort(406);
        }

        $route = route('actor') . '/outbox';

        $notes = Note::orderBy('published_at', 'DESC')->get();

        if ($request->get('page')) {
            return response()->json([
                '@context' => 'https://www.w3.org/ns/activitystreams',
                'id' => $route . '?page=true',
                'type' => 'OrderedCollectionPage',
                'totalItems' => $notes->count(),
                'partOf' => $route,
                'orderedItems' => $notes->map->toObject(),
            ]);
        } else {
            return response()->json([
                '@context' => 'https://www.w3.org/ns/activitystreams',
                'id' => $route,
                'type' => 'OrderedCollection',
                'totalItems' => $notes->count(),
                'first' => $route . '?page=true',
            ]);
        }
    }
}
