<?php

namespace App\Services\Email\Handler;

use App\Services\Email\AbstractEmailHandler;
use EmailGateway\EmailGateway;

class PostmarkHandler extends AbstractEmailHandler
{
    public function sendEmail($email)
    {
        // Prepare data
        $email['from'] = $this->config['from'];

        // Send and get result
        $emailGateway = new EmailGateway($this->config['handler'], $email, $this->config);
        $result = $emailGateway->send();

        if ($result['status'] == 'success') {

            $this->logger->info(__METHOD__, $result);

        }

        return $result;
    }
}
