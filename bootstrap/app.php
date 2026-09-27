<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
        ]);
        $middleware->redirectGuestsTo(function (Request $request) {
            return $request->is('admin') || $request->is('admin/*')
                ? route('admin.login')
                : route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $exception, Request $request) {
            if (config('app.dev_mode')) {
                return null;
            }

            Log::error('Acryluxe application exception.', [
                'exception' => $exception,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'user_id' => $request->user()?->id,
            ]);

            try {
                Mail::raw(
                    implode("\n", [
                        'Acryluxe application exception',
                        '',
                        'Time: ' . now()->toDateTimeString(),
                        'Environment: ' . config('app.env'),
                        'Method: ' . $request->method(),
                        'URL: ' . $request->fullUrl(),
                        'User ID: ' . ($request->user()?->id ?? 'guest'),
                        'Exception: ' . get_class($exception),
                        'Message: ' . $exception->getMessage(),
                        '',
                        $exception->getTraceAsString(),
                    ]),
                    function ($message): void {
                        $message->to(config('auth.admin_email'))
                            ->subject('Acryluxe application exception');
                    },
                );
            } catch (Throwable $mailException) {
                Log::error('Unable to email the Acryluxe exception report.', [
                    'exception' => $mailException,
                    'original_exception' => $exception,
                ]);
            }

            return response()->view('errors.maintenance', status: 503);
        });
    })->create();
