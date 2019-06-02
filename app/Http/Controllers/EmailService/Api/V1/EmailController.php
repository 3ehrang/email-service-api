<?php

namespace App\Http\Controllers\EmailService\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    /**
     * Get email data and send it
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        // Get input
        $input = $request->only(
            'subject', 'from', 'fromName', 'to', 'toName', 'content', 'contentType'
        );

        // Return success response
        $response = [
            'status' => 'success',
            'message' => 'Queued. Thank you.',
            'data' => $input
        ];

        return response()->json($response, 200);
    }
}
