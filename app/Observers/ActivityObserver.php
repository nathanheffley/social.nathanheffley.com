<?php

namespace App\Observers;

use App\Activity;
use App\Follower;
use App\User;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class ActivityObserver
{
    public function created(Activity $activity)
    {
        $object = $activity->object;

        if (count($object->cc) < 1) {
            return;
        }

        if ($object->cc === [route('followers')]) {
            $sharedInboxes = Follower::whereNotNull('shared_inbox')->get('shared_inbox')->pluck('shared_inbox')->filter()->unique();
            $uniqueInboxes = Follower::whereNull('shared_inbox')->get('inbox')->pluck('inbox')->filter()->unique();
            $inboxes = $uniqueInboxes->merge($sharedInboxes);

            $client = new Client();
            $key = openssl_pkey_get_private(User::first()->private_key);

            $inboxes->each(function ($inbox) use ($client, $key, $activity) {
                $date = new DateTime('UTC');
                $headers = [
                    '(request-target)' => 'post ' . parse_url($inbox, PHP_URL_PATH),
                    'Date' => $date->format('D, d M Y H:i:s \G\M\T'),
                    'Host' => parse_url($inbox, PHP_URL_HOST),
                    'Content-Type' => 'application/activity+json',
                ];

                $stringToSign = implode("\n", array_map(function($k, $v){
                    return strtolower($k).': '.$v;
                }, array_keys($headers), $headers));

                $signedHeaders = implode(' ', array_map('strtolower', array_keys($headers)));

                openssl_sign($stringToSign, $signature, $key, OPENSSL_ALGO_SHA256);
                $signature = base64_encode($signature);
                $signatureHeader = 'keyId="' . route('actor') .'",headers="'.$signedHeaders.'",algorithm="rsa-sha256",signature="'.$signature.'"';

                unset($headers['(request-target)']);

                $headers['Signature'] = $signatureHeader;

                $response = $client->post($inbox, [
                    'headers' => $headers,
                    'json' => $activity->toObject(),
                ]);
                \Log::debug(json_encode($response));
            });
        }
    }
}
