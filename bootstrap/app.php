<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        // Trust all proxies (Vercel reverse-proxy) so URL/asset helpers generate https
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->view('errors.404', [], 404);
        });
    })->create();

if (env('APP_STORAGE_PATH')) {
    $app->useStoragePath(env('APP_STORAGE_PATH'));
}

return $app;
