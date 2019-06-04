<?php
/**
 * Email service for sending, storing and retrieving emails.
 */

namespace App\Services;

use App\Repositories\EmailEloquent;
use App\Services\Interfaces\EmailServiceInterface;

/**
 * Class EmailService
 * @package App\Services
 */
class EmailService implements EmailServiceInterface
{
    public function send($sid, array $attributes)
    {
        $emailHandler = new EmailHandler();

        $result = $emailHandler->send($attributes);

        // Update email record based on send result
        $EmailElq = new EmailEloquent();
        if ($result['status'] == 'success') {

            $EmailElq->setAsSent($sid);

        } else {

            $EmailElq->setAsFailed($sid);

        }
    }
}
