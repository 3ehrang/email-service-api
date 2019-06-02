<?php

namespace App\Http\Controllers\EmailService\Api\V1;

use App\Http\Requests\SendEmailPost;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
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

        $response = [
            'status' => 'success',
            'message' => 'Queued. Thank you.',
            'data' => $input
        ];

        return response()->json($response, 200);
    }
}
