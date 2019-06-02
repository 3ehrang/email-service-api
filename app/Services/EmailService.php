<?php
/**
 * Email service for sending, storing and retrieving emails.
 */

namespace App\Services;

use App\Services\Email\Handler\SendGridHandler;
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
        $sendGridHandler    = new SendGridHandler(config('gateways.senders.sendGrid'));

        $result = $sendGridHandler->handle($attributes);

        if ($result['status'] == 'success') {

            // TODO: Update email's status = 2 means is sent

        } else {

            // TODO: Update email's status = 3
            // TODO: Worst case scenario if email was not sent

        }

        return $result;
    }
}
