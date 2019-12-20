<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'private_key', 'password', 'remember_token',
    ];

    public function toActor()
    {
        return [
            '@context' => [
                'https://www.w3.org/ns/activitystreams',
                'https://w3id.org/security/v1',
            ],

            'id' => route('actor'),
            'type' => 'Person',
            'preferredUsername' => $this->username,
            'inbox' => route('inbox'),

            'publicKey' => [
                'id' => route('actor') . '#public-key',
                'owner' => route('actor'),
                'publicKeyPem' => $this->public_key,
            ],
        ];
    }

    public function toWebfinger()
    {
        return [
            'subject' => sprintf('acct:%s@%s', $this->username, config('app.host')),

            'links' => [
                [
                    'rel' => 'self',
                    'type' => 'application/activity+json',
                    'href' => route('actor'),
                ],
            ],
        ];
    }
}
