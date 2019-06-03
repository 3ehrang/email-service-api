<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($this->getLogFormatter());
        }
    }

    protected function getLogFormatter()
    {
        $sid = request()->input('sid');

        $format = str_replace(
            '[%datetime%] ',
            sprintf('[%%datetime%%] %s ', $sid),
                    LineFormatter::SIMPLE_FORMAT
            );

        return new LineFormatter($format, null, true, true);
    }
}
