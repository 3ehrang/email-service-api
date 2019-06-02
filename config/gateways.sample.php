<?php

use EmailGateway\Adapter\SendGridAdp;

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

    ],

];
