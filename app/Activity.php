<?php

namespace App;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use Uuid;

    protected $fillable = [
        'type',
        'object_type',
        'object_uuid',
    ];

    public function object()
    {
        return $this->morphTo(null, null, 'object_uuid');
    }

    public function toObject()
    {
        return [
            '@context' => 'https://www.w3.org/ns/activitystreams',
            'id' => route('activity', ['activity' => $this]),
            'type' => $this->type,
            'actor' => route('actor'),
            'object' => $this->object->toObject(),
        ];
    }
}
