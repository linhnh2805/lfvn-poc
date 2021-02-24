<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class FcmService {

    protected static $url = "https://fcm.googleapis.com/fcm/send";
    protected static $key = env('FCM_KEY');
    protected static $default_title = "LFVN Notification";
    protected static $default_icon = "ic_notification_price";
    protected static $default_sound = "unconvinced";
    protected static $tag = 'LFVN';

  /**
     * @param $data
     * @param $topicName
     * @throws GuzzleException
     */
    public function sendNotification($token, $title, $message, $action)
    {
        print ('Send notification to: ' . $token);
        $client = new Client(['headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'key='. self::$key
        ],  'verify' => false
        ]);

        $res = $client->post(self::$url, [
            'json' => $this->generateBody($token, $title, $message, $action)
        ]);

        // $data = [
        //     'to' => $clientId,
        //     'notification' => [
        //         'body' => $data['body'] ?? 'Something',
        //         'title' => $data['title'] ?? 'Something',
        //         'image' => $data['image'] ?? null,
        //     ]
        // ];

        // $this->execute($url, $data);
    }

    function generateBody($token, $title, $message, $action) {
        $body = [
            'to' => $token,
            'notification' => [
                'body' => $message,
                'title' => $title,
                'tag' => self::$tag,
                'icon' => self::$default_icon,
                'sound' => self::$default_sound,
                'click_action' => $action
            ]
        ];

        return $body;
    }
}