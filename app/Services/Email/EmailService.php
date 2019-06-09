<?php
/**
 * Email service for sending, storing and retrieving emails.
 */

namespace App\Services\Email;

use App\Events\OperationFailed;
use App\Models\Data\EmailData;
use App\Repositories\Interfaces\EmailRepoInterface;
use App\Services\Email\EmailServiceInterface;
use App\Services\Email\Handler\EmailHandler;
use App\Services\Email\Handler\Handlers\PostmarkHandler;
use App\Services\Email\Handler\Handlers\SendGridHandler;
use App\Services\Email\Handler\Handlers\SendPulseHandler;
use Log;

/**
 * Class EmailService
 * @package App\Services
 */
class EmailService implements EmailServiceInterface
{

    /**
     * @var EmailRepoInterface
     */
    protected $emailEloquent;

    /**
     * EmailService constructor.
     *
     * @param EmailRepoInterface $emailEloquent
     */
    public function __construct(EmailRepoInterface $emailEloquent)
    {
        $this->emailEloquent = $emailEloquent;
    }

    public function create(array $attributes)
    {
        return $this->emailEloquent->create($attributes);
    }

    /**
     * Send email and update emails table based on result staus
     *
     * @param string $sid Request service Id
     * @param EmailData $emailData Email sending data
     *
     * @return mixed
     */
    public function send($sid, EmailData $emailData)
    {
        // Create handlers and send email
        $emailHandler = new EmailHandler(Log::getLogger());
        $result = $emailHandler->send(
            [
                [SendGridHandler::class, config('gateways.senders.sendGrid')],
                [SendPulseHandler::class, config('gateways.senders.sendPulse')],
                [PostmarkHandler::class, config('gateways.senders.postMark')]
            ],
            $emailData->toArray()
        );

        // Update email record based on the result
        if ($result['status'] == 'success') {

            $this->emailEloquent->setAsSent($sid);
            Log::info($sid . ' ' . __METHOD__, $result);

        } else {

            $this->emailEloquent->setAsFailed($sid);

            // If All handlers was failed to send email
            event(new OperationFailed($emailData, $sid));

        }

        return $result;
    }
}
