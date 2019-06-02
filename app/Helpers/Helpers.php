<?php

/**
 * API Response in Jsend format
 *
 * @link: https://github.com/omniti-labs/jsend
 */

if (!function_exists('api_success')) {
    /**
     * @param string|null $message
     * @param array|Illuminate\Database\Eloquent\Model $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function api_success($message = null, $data = [], $status = 200, $extraHeaders = [])
    {
        $response = [
            'status' => 'success',
        ];
        !is_null($message) && $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists('api_fail')) {
    /**
     * @param string|null $message
     * @param array $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function api_fail($message = null, $data, $status = 400, $extraHeaders = [])
    {
        $response = [
            'status' => 'fail',
        ];
        !is_null($message) && $response['message'] = $message;
        $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists('api_error')) {
    /**
     * @param string $message Error message
     * @param string $code Optional custom error code
     * @param string | array $data Optional data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function api_error($message, $data = null, $code = null, $status = 500, $extraHeaders = [])
    {
        $response = [
            'status' => 'error',
            'message' => $message
        ];
        !is_null($code) && $response['code'] = $code;
        !is_null($data) && $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }
}
