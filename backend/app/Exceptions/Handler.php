<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'message' => 'Resource not found.',
                'status' => 404
            ]);
        }

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors(),
                'status' => 422
            ]);
        }

        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json([
                'message' => 'Unauthorized.',
                'status' => 401
            ]);
        }

        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'status' => 401
            ]);
        }

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'message' => 'Resource not found.',
                'error' => $e->getMessage(),
                'status' => 404
            ]);
        }

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json([
                'message' => 'Method not allowed.',
                'error' => 'Allowed method is ' . implode(', ', $e->getHeaders()),
                'status' => 405
            ]);
        }

        return parent::render($request, $e);
    }
}
