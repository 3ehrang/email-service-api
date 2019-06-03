<?php

namespace App\Services\Email\Handler;

use App\Services\Email\AbstractEmailHandler;
use EmailGateway\EmailGateway;

class SendPulseHandler extends AbstractEmailHandler
{
    public function sendEmail($email)
    {
        // Prepare data
        $email['from'] = $this->config['from'];

        // Send and get result
        $emailGateway = new EmailGateway($this->config['handler'], $email, $this->config);
        $result = $emailGateway->send();

        if ($result['status'] != 'success') {

            // TODO: Implement log email data.

        }

        return $result;
    }
}
