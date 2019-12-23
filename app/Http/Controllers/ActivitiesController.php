<?php

namespace App\Http\Controllers;

use App\Activity;

class ActivitiesController extends Controller
{
    public function show(Activity $activity)
    {
        return response()->json($activity->toObject());
    }
}
