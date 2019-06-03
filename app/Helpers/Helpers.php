<?php

/**
 * API Response in Jsend format
 *
 * @link: https://github.com/omniti-labs/jsend
 */

if (!function_exists('api_success')) {
    /**
     * @param array $data
     * @param int $status HTTP status code
     * @param array $extraHeaders
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function api_success($data, $status = 200, $extraHeaders = [])
    {
        $response = [
            'status' => 'success',
        ];

        $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists('api_fail')) {
    /**
     * @param array $data
     * @param int $status HTTP status code
     * @param array $extraHeaders Optional
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function api_fail($data, $status = 400, $extraHeaders = [])
    {
        $response = [
            'status' => 'fail',
        ];

        $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }
}

if (!function_exists('api_error')) {
    /**
     * @param string $message Error message
     * @param int $status HTTP status code
     * @param string | array $data
     * @param string $code Optional custom error code
     * @param array $extraHeaders
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function api_error($message, $status = 500,  $data = null, $code = null, $extraHeaders = [])
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
