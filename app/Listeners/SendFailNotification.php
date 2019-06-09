<?php

namespace App\Listeners;

use App\Events\OperationFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendFailNotification implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'bifrost-redis';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 10;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OperationFailed  $event
     * @return void
     */
    public function handle(OperationFailed $event)
    {
        // TODO: Send an email to administrator or log to slack channel or whatever ...
        Log::info($event->sid . ' Operation Failed', $event->emailData->toArray() );
    }

    /**
     * Handle a job failure.
     *
     * @param  OperationFailed  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(OperationFailed $event, $exception)
    {
        // TODO: If our queued event fail so here will be the worst case scenario
    }
}
