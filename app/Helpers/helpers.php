<?php

if (!function_exists('default_profile_image')) {
    function default_profile_image()
    {
        return asset('images/default-profile.png');
    }
}


if (!function_exists('successResponse')) {
    function successResponse($message, $data = [], $status = 200)
    {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
        ], $data), $status);
    }
}
if (!function_exists('errorResponse')) {
    function errorResponse($message, $error = null, $status = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error,
        ], $status);
    }

}


