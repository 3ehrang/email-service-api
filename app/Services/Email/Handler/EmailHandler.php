<?php
/**
 * Email Handler for sending emails via different platforms.
 */

namespace App\Services\Email\Handler;

use App\Services\Email\Handler\Handlers\PostmarkHandler;
use App\Services\Email\Handler\Handlers\SendGridHandler;
use App\Services\Email\Handler\Handlers\SendPulseHandler;
use Log;

/**
 * Class EmailService
 * @package App\Services
 */
class EmailHandler
{
    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function send(array $attributes)
    {
        // Define email handler
        $sendGridHandler    = new SendGridHandler(config('gateways.senders.sendGrid'), Log::getLogger());
        $sendPulseHandler   = new SendPulseHandler(config('gateways.senders.sendPulse'), Log::getLogger());
        $postmarkHandler    = new PostmarkHandler(config('gateways.senders.postMark'), Log::getLogger());

        $sendGridHandler
            ->linkWith($sendPulseHandler)
            ->linkWith($postmarkHandler)
        ;
        $result = $sendGridHandler->handle($attributes);

        return $result;
    }
}
