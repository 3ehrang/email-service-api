<?php

namespace App\Services\Email\Handler;

use App\Services\Email\AbstractEmailHandler;

class SendPulseHandler extends AbstractEmailHandler
{
    public function sendEmail($email)
    {
        return parent::sendEmail($email);
    }
}
