<?php

namespace App\Services\Email\Handler;

/**
 * The Handler interface declares a method for building the chain of handlers.
 * It also declares a method for Sending an email a request.
 */
interface EmailHandlerInterface
{
    public function linkWith(AbstractEmailHandler $successor);

    public function handle($email);
}
