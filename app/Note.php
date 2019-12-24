<?php

namespace App;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use Uuid;

    protected $fillable = [
        'content',
        'attachment',
        'attributed_to',
        'in_reply_to',
        'to',
        'cc',
        'published_at',
    ];

    protected $casts = [
        'attachment' => 'array',
        'attributed_to' => 'array',
        'in_reply_to' => 'array',
        'to' => 'array',
        'cc' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    public function toObject()
    {
        return [
//            '@context' => 'https://www.w3.org/ns/activitystreams',
            'id' => route('note', ['note' => $this]),
            'type' => 'Note',
            'published' => $this->published_at,
            'attributedTo' => $this->attributed_to,
            'inReplyTo' => $this->in_reply_to,
            'content' => $this->content,
            'attachment' => $this->attachment,
            'to' => $this->to,
            'cc' => $this->cc,
        ];
    }
}
