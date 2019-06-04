<?php

namespace App\Services\Email\Handler;

use App\Services\Email\AbstractEmailHandler;
use EmailGateway\EmailGateway;

class SendGridHandler extends AbstractEmailHandler
{
    public function sendEmail($email)
    {
        // Prepare data
        $email['from'] = $this->config['from'];
        $email['fromName'] = $this->config['fromName'];

        // Send and get result
        $emailGateway = new EmailGateway($this->config['handler'], $email, $this->config);
        $result = $emailGateway->send();

        // If success log data
        if ($result['status'] == 'success') {

            $this->logger->info(__METHOD__, $result);

        }

        return $result;
    }
}
