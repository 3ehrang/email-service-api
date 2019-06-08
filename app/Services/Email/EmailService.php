<?php
/**
 * Email service for sending, storing and retrieving emails.
 */

namespace App\Services\Email;

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
     * @param array $attributes Email sending data
     *
     * @return mixed
     */
    public function send($sid, array $attributes)
    {
        $emailHandler = new EmailHandler(Log::getLogger());

        $result = $emailHandler->send([
            [SendGridHandler::class, config('gateways.senders.sendGrid')],
            [SendPulseHandler::class, config('gateways.senders.sendPulse')],
            [PostmarkHandler::class, config('gateways.senders.postMark')]
        ], $attributes);

        // Update email record based on send result
        if ($result['status'] == 'success') {

            $this->emailEloquent->setAsSent($sid);
            Log::info(__METHOD__, $result);

        } else {

            $this->emailEloquent->setAsFailed($sid);

            // TODO: Worst case scenario for failed

        }

        return $result;
    }
}
