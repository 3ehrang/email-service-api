<?php

namespace App\Jobs;

use App\Models\Data\EmailData;
use App\Services\Email\EmailServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Email sending data
     * @var EmailData
     */
    public $data;

    /**
     * Request service id
     *
     * @var string
     */
    protected $sid;

    /**
     * Create a new job instance.
     *
     * @param string $sid
     * @param EmailData $data
     *
     * @return void
     */
    public function __construct($sid, EmailData $data)
    {
        $this->sid = $sid;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param EmailServiceInterface $emailService
     *
     * @return void
     */
    public function handle(EmailServiceInterface $emailService)
    {
        $emailService->send($this->sid, $this->data);
    }
}
