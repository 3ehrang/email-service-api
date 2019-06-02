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
        // Get input
        $input = $request->only(
            'subject', 'from', 'fromName', 'to', 'toName', 'content', 'contentType'
        );

        // Save Email data and handle error if happened
        try {

            $this->emailEloquent->create(['data' => $input]);

        } catch (\Exception $e) {

            // Return fail response
            return api_fail('Unable to communicate with database.', $input, 422);

        }

        // Send data to email service
        $this->emailService->send($input);

        // Return success response
        return api_success('Queued. Thank you.', $input);
    }
}
