<?php

use EmailGateway\Adapter\SendGridAdp;
use EmailGateway\Adapter\SendPulseAdp;
use EmailGateway\Adapter\PostmarkAdp;

return [

    /*
    |--------------------------------------------------------------------------
    | Send Gateways
    |--------------------------------------------------------------------------
    |
    | Here you may configure the email handlers for your application.
    |
    | Available Handler: "sendGrid", "sendPulse", "postMark", ...
    |
    */

    'senders' => [

        'sendGrid' => [
            'enable' => true,
            'handler' => SendGridAdp::class,
            'apiKey' => '',
            'from' => '',
            'fromName' => ''
        ],

        'sendPulse' => [
            'enable' => true,
            'handler' => SendPulseAdp::class,
            'id' => '',
            'secret' => '',
            'from' => '',
            'fromName' => ''
        ],

        'postMark' => [
            'enable' => true,
            'handler' => PostmarkAdp::class,
            'serverToken' => '',
            'from' => '',
            'fromName' => ''
        ],

    ],

];
