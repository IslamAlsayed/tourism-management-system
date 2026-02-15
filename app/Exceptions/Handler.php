<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            if ($request->expectsJson()) {
                return response()->json(['message' => __('Method Not Allowed.')], 405);
            }

            return redirect()->route('auth.login')->withErrors(__('The Request Method Is Not Allowed.'));
        }

        if ($exception instanceof AuthorizationException) {
            dd('Authorization Exception: ' . $exception->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['message' => __('messages.unauthorized_action')], 403);
            }

            return redirect()->back()->withError(__('messages.unauthorized_action'));
        }

        // Handle 403 Forbidden errors
        if ($exception instanceof HttpException && $exception->getStatusCode() === 403) {
            dd('Authorization Exception: ' . $exception->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['message' => __('messages.unauthorized_action')], 403);
            }

            return redirect()->back()->withError(__('messages.unauthorized_action'));
        }

        return parent::render($request, $exception);
    }

    public function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('auth.login'));
    }
}
