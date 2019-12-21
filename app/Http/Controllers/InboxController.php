<?php

namespace App\Http\Controllers;

use App\Follower;
use DateTime;
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
                \Log::debug('Unknown request received', [
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

        Follower::firstOrCreate([
            'actor' => $request->get('actor'),
        ]);

        /** @var \App\User $user */
        $user = \App\User::first();

        $client = new \GuzzleHttp\Client();

        $actor = json_decode($client->get($request->get('actor'), [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ])->getBody()->getContents());

        $date = new DateTime('UTC');
        $headers = [
            '(request-target)' => 'post ' . parse_url($actor->inbox, PHP_URL_PATH),
            'Date' => $date->format('D, d M Y H:i:s \G\M\T'),
            'Host' => parse_url($actor->inbox, PHP_URL_HOST),
            'Content-Type' => 'application/activity+json',
        ];

        $stringToSign = implode("\n", array_map(function($k, $v){
            return strtolower($k).': '.$v;
        }, array_keys($headers), $headers));

        $signedHeaders = implode(' ', array_map('strtolower', array_keys($headers)));

        $key = openssl_pkey_get_private($user->private_key);
        openssl_sign($stringToSign, $signature, $key, OPENSSL_ALGO_SHA256);
        $signature = base64_encode($signature);
        $signatureHeader = 'keyId="' . route('actor') .'",headers="'.$signedHeaders.'",algorithm="rsa-sha256",signature="'.$signature.'"';

        unset($headers['(request-target)']);

        $headers['Signature'] = $signatureHeader;

        $client->post($actor->inbox, [
            'headers' => $headers,
            'json' => [
                '@context' => 'https://www.w3.org/ns/activitystreams',
                'type' => 'Accept',
                'object' => $request->json()->all(),
            ],
        ]);

        return response()->json();
    }
}
