<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'actor';

    protected $keyType = 'string';

    protected $fillable = [
        'actor',
    ];
}
