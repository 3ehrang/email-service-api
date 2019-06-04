<?php

namespace App\Http\Controllers\EmailService\Api\V1;

use App\Http\Requests\SendEmailPost;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\EmailRepoInterface;
use App\Services\Interfaces\EmailServiceInterface;

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

        // Response Data
        $dataReturn = [
            'sid' => $sid,
            'received' => $emailData
        ];

        // Save Email data and handle error if happened
        try {

            $this->emailEloquent->create(['app_id' => $appId, 'sid' => $sid, 'data' => $emailData]);

        } catch (\Exception $e) {

            // Return error response
            return api_error('Unable to communicate with database.', 422, $dataReturn);

        }

        // Send data to email service
        $result = $this->emailService->send($request->all());

        // Update email record based on send result
        if ($result['status'] == 'success') {

            $this->emailEloquent->setAsSent($sid);

        } else {

            $this->emailEloquent->setAsFailed($sid);

        }

        // Return success response
        return api_success($dataReturn,200);
    }
}
