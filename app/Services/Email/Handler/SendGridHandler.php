<?php

namespace App\Services\Email\Handler;

use App\Services\Email\AbstractEmailHandler;

class SendGridHandler extends AbstractEmailHandler
{
    public function sendEmail($email)
    {
        return parent::sendEmail($email);
    }
}
