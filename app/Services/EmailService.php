<?php
/**
 * Email service for sending, storing and retrieving emails.
 */

namespace App\Services;

use App\Services\Email\Handler\PostmarkHandler;
use App\Services\Email\Handler\SendGridHandler;
use App\Services\Email\Handler\SendPulseHandler;
use App\Services\Interfaces\EmailServiceInterface;
use Log;

/**
 * Class EmailService
 * @package App\Services
 */
class EmailService implements EmailServiceInterface
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
