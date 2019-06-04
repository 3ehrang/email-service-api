<?php

namespace App\Services\Email;

use Psr\Log\LoggerInterface;

/**
 * The default chaining behavior for Email handlers defined here.
 */
abstract class AbstractEmailHandler implements EmailHandlerInterface
{
    /**
     * @var AbstractEmailHandler
     */
    private $next = null;

    /**
     * Handler config
     *
     * @var array
     */
    protected $config;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * AbstractEmailHandler constructor.
     *
     * @param array           $config
     * @param LoggerInterface $logger
     */
    public function __construct($config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Sets a successor handler,
     * in case the class is not able to send email.
     *
     * @param AbstractEmailHandler $next
     *
     * @return AbstractEmailHandler
     */
    final public function linkWith(AbstractEmailHandler $next)
    {
        $this->next = $next;
        return $next;
    }

    /**
     * Send email
     *
     * @param array $email
     *
     * @return mixed
     */
    public function handle($email)
    {
        $response = $this->sendEmail($email);

        if (($response['status'] != 'success') && $this->next) {
            return $this->next->handle($email);
        }

        return $response;
    }

    /**
     * Send email
     * This is the only method a child can implements,
     * with the constraint to return null to dispatch the request to next successor.
     *
     * @param $email array
     *
     * @return null|mixed
     */
    abstract protected function sendEmail($email);
}
