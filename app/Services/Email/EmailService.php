<?php
/**
 * Email service for sending, storing and retrieving emails.
 */

namespace App\Services\Email;

use App\Repositories\Interfaces\EmailRepoInterface;
use App\Services\Email\EmailServiceInterface;
use App\Services\Email\Handler\EmailHandler;

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

    public function send($sid, array $attributes)
    {
        $emailHandler = new EmailHandler();

        $result = $emailHandler->send($attributes);

        // Update email record based on send result
        if ($result['status'] == 'success') {

            $this->emailEloquent->setAsSent($sid);

        } else {

            $this->emailEloquent->setAsFailed($sid);

        }

        return $result;

    }
}
