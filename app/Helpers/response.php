<?php

function successResponse($message, $data = [], $status = 200)
{
    return response()->json(array_merge([
        'success' => true,
        'message' => $message,
    ], $data), $status);
}

function errorResponse($message, $error = null, $status = 500)
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'error' => $error,
    ], $status);
}
