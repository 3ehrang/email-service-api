<?php

namespace App\Services\Email\Handler\Handlers;

use App\Services\Email\Handler\AbstractEmailHandler;

class SendPulseHandler extends AbstractEmailHandler
{
    public function sendEmail($email)
    {
        return parent::sendEmail($email);
    }
}
