<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InboxController
{
    public function store(Request $request)
    {
        if ($request->get('@context') !== 'https://www.w3.org/ns/activitystreams') {
            return response()->json([
                'message' => 'Only @context: https://www.w3.org/ns/activitystreams requests are supported',
            ], 400);
        }

        \Log::debug($request);

        switch ($request->get('type')) {
            case 'Follow':
                return $this->follow($request);
            default:
                \Log::debug('Unknown requets received', [
                    'data' => $request,
                ]);
                return response()->json();
        }
    }

    protected function follow(Request $request)
    {
        if (empty($request->get('actor')) || empty($request->get('object'))) {
            return response()->json([
                'message' => 'Request to follow must contain an actor and an object',
            ], 400);
        }

        if ($request->get('object') !== route('actor')) {
            return response()->json([
                'message' => 'Unknown actor',
            ], 404);
        }

        return response();
    }
}
