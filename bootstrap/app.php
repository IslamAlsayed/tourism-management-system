<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web([
            \App\Http\Middleware\SetLocale::class,
            // \App\Http\Middleware\CheckImportExportMessages::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (\Throwable $exception): void {
            if (!config('activitylog.enabled')) {
                return;
            }
            if (!config('activitylog.system_log_name')) {
                return;
            }
            if (!Schema::hasTable(config('activitylog.table_name', 'activity_log'))) {
                return;
            }
            if (app()->runningInConsole()) {
                return;
            }
            if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404) {
                return;
            }
            $hasRequest = app()->bound('request') && request();
            $properties = [
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => collect($exception->getTrace())
                    ->map(function ($item) {
                        return [
                            'file' => $item['file'] ?? null,
                            'line' => $item['line'] ?? null,
                            'function' => $item['function'] ?? null,
                            'class' => $item['class'] ?? null,
                        ];
                    })->take(10)->values()->all(),
            ];
            if ($hasRequest) {
                $properties['url'] = request()->fullUrl();
                $properties['ip'] = request()->ip();
                $properties['user_agent'] = request()->userAgent();
                $properties['method'] = request()->method();
                $properties['input'] = collect(request()->except(['password', 'password_confirmation']))->take(15)->all();
            }
            activity(config('activitylog.system_log_name'))
                ->causedBy(Auth::user())
                ->event('error')
                ->withProperties($properties)
                ->log($exception->getMessage() ?: 'Unhandled exception');
        });
    })->create();