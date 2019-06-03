<?php
/**
 * Email service for sending, storing and retrieving emails.
 */

namespace App\Services;

use App\Repositories\EmailEloquent;
use App\Services\Email\Handler\PostmarkHandler;
use App\Services\Email\Handler\SendGridHandler;
use App\Services\Email\Handler\SendPulseHandler;
use App\Services\Interfaces\EmailServiceInterface;

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
        $sendGridHandler    = new SendGridHandler(config('gateways.senders.sendGrid'));
        $sendPulseHandler   = new SendPulseHandler(config('gateways.senders.sendPulse'));
        $postmarkHandler    = new PostmarkHandler(config('gateways.senders.postMark'));

        $sendGridHandler
            ->linkWith($sendPulseHandler)
            ->linkWith($postmarkHandler)
        ;
        $result = $sendGridHandler->handle($attributes);

        return $result;

    }
}
