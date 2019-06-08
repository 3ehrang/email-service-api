<?php

namespace App\Console\Commands;

use App\Lib\ServiceIdentifier;
use App\Services\Email\EmailServiceInterface;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails by email service using different emails platform';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param EmailServiceInterface $emailService
     *
     * @return mixed
     */
    public function handle(EmailServiceInterface $emailService)
    {

        $this->info('Welcome to email sending CLI');

        $subject = $this->ask('Subject');
        $from = $this->ask('From');
        $to = $this->ask('To');
        $content = $this->ask('Content');

        if ($this->confirm('Do you wish to send?')) {

            /*
             * Received email data
             */
            $emailData = [
                'subject' => $subject,
                'form' => $from,
                'to' => $to,
                'content' => $content,
                'toName' => '',
                'fromName' => '',
                'contentType' => 'text/string',
            ];

            /*
             * Data for save in emails table
             */
            $emailRecord = [
                'status' => 0,
                'app_id' => 'CLI',
                'sid' => ServiceIdentifier::Create(),
                'data' => json_encode($emailData),
            ];

            // Create a new email row
            $result = $emailService->create($emailRecord);

            // Send email and get result
            $sendResult = $emailService->send($emailRecord['sid'], $emailData);

            $this->info($sendResult['status']);

        }

    }
}
