<?php

namespace App\Http\Controllers;

use App\Note;

class NotesController extends Controller
{
    public function show(Note $note)
    {
        return response()->json($note->toObject());
    }
}
