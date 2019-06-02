<?php

namespace App\Http\Controllers\EmailService\Api\V1;

use App\Http\Requests\SendEmailPost;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\EmailRepoInterface;

class EmailController extends Controller
{
    /**
     * @var EmailRepoInterface
     */
    private $emailEloquent;

    /**
     * EmailController constructor.
     *
     * @param EmailRepoInterface $emailEloquent
     */
    public function __construct(EmailRepoInterface $emailEloquent)
    {
        $this->emailEloquent = $emailEloquent;
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
            $response = [
                'status' => 'success',
                'message' => 'Unable to communicate with database.',
                'data' => $input
            ];
            return response()->json($response, 422);

        }

        $response = [
            'status' => 'success',
            'message' => 'Queued. Thank you.',
            'data' => $input
        ];

        return response()->json($response, 200);
    }
}
