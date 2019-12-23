<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PublishPost extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $note = new Note([
            'content' => $request->get('content'),
            'attachment' => [],
            'attributed_to' => [route('actor')],
            'in_reply_to' => [],
            'to' => ['https://www.w3.org/ns/activitystreams#Public'],
            'cc' => [route('followers')],
            'published_at' => Carbon::now(),
        ]);
        $note->save();

        $create = new Activity([
            'type' => 'Create',
            'object_type' => Note::class,
            'object_uuid' => $note->fresh()->uuid,
        ]);
        $create->save();

        return redirect(route('home'));
    }
}
