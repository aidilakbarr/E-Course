<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

if (! function_exists('default_profile_image')) {
    function default_profile_image()
    {
        return asset('images/default-profile.png');
    }
}

if (! function_exists('successResponse')) {
    function successResponse($message, $data = [], $status = 200)
    {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
        ], $data), $status);
    }
}
if (! function_exists('errorResponse')) {
    function errorResponse($message, $error = null, $status = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error,
        ], $status);
    }

}

if (! function_exists('handleError')) {
    function handleError(\Throwable $e, string $defaultMessage = 'Terjadi kesalahan, silakan coba lagi.')
    {
        \Log::error($e);

        if ($e instanceof ModelNotFoundException) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        if ($e instanceof QueryException) {
            return redirect()->back()->with('error', 'Kesalahan query database.');
        }

        if ($e instanceof HttpException) {
            return redirect()->back()->with('error', 'Error HTTP: '.$e->getStatusCode());
        }

        if (str_contains($e->getMessage(), 'upload')) {
            return redirect()->back()->with('error', 'Upload gagal, coba file lain.');
        }

        if (config('app.debug')) {
            return redirect()->back()->with('error', 'Debug: '.$e->getMessage());
        }

        return redirect()->back()->with('error', $defaultMessage);
    }
}
