<?php

namespace App\Http\Controllers\EmailService\Api\V1;

use App\Http\Requests\SendEmailPost;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessSaveEmail;
use App\Jobs\ProcessSendEmail;
use App\Models\Data\EmailData;
use App\Repositories\Interfaces\EmailRepoInterface;
use App\Services\Email\EmailServiceInterface;

class EmailController extends Controller
{
    /**
     * @var EmailRepoInterface
     */
    private $emailEloquent;

    /**
     * @var EmailServiceInterface
     */
    private $emailService;

    /**
     * EmailController constructor.
     *
     * @param EmailRepoInterface $emailEloquent
     * @param EmailServiceInterface $emailService
     */
    public function __construct(EmailRepoInterface $emailEloquent, EmailServiceInterface $emailService)
    {
        $this->emailEloquent = $emailEloquent;
        $this->emailService = $emailService;
    }

    /**
     * Return all emails
     *
     * @return array
     */
    public function index()
    {
        return $this->emailEloquent->all();
    }

    /**
     * Get email data and send it
     *
     * @param SendEmailPost $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(SendEmailPost $request)
    {
        // Get input data
        $emailData = $request->only(
            'subject', 'from', 'fromName', 'to', 'toName', 'content', 'contentType'
        );
        $sid = $request->input('sid');
        $appId = $request->input('app_id');

        // Create EmailData model
        $emailDataModel = new EmailData($emailData);

        // Response Data
        $dataReturn = [
            'sid' => $sid,
            'received' => $emailDataModel->toArray()
        ];

        // Send to queue for saving incoming data
        $saveData = [
            'app_id' => $appId,
            'sid' => $sid,
            'received_at' => now(),
            'data' => $emailDataModel->toArray()
        ];
        ProcessSaveEmail::dispatch($saveData)
            ->delay(now()->addSeconds(10))
            ->onQueue('saveEmail')
        ;

        // Send to queue for sending
        ProcessSendEmail::dispatch($sid, $emailDataModel)
            ->delay(now()->addSeconds(20))
            ->onQueue('sendEmail')
        ;

        // Return success response
        return api_success($dataReturn,200);
    }
}
