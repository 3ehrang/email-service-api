<?php
/**
 * Email Handler for sending emails via different platforms.
 */

namespace App\Services\Email\Handler;

use Psr\Log\LoggerInterface;

/**
 * Class EmailService
 * @package App\Services
 */
class EmailHandler
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * EmailHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param EmailHandlerInterface[] $handlers
     * @param array $attributes
     *
     * @return mixed
     */
    public function send(array $handlers, $attributes)
    {
        /* @var $prepareHandlers EmailHandlerInterface[] */
        $prepareHandlers = [];

        /**
         * $handler[0] = classname
         * $handler[1] = config
         */
        foreach ($handlers as $handler) {
            $prepareHandlers[] = new $handler[0]($handler[1], $this->logger);
        }

        // Fill each handler with next handler
        foreach ($prepareHandlers as $i => $prepareHandler) {

            if ($i+1 < count($prepareHandlers)) {
                $prepareHandler->linkWith($prepareHandlers[$i+1]);
            }
        }

        $result = $prepareHandlers[0]->handle($attributes);

        return $result;
    }
}
