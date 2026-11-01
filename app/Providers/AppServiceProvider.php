<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinutes(10, 3)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    $message = 'Terlalu banyak permintaan pengiriman pesan. Silakan coba lagi dalam beberapa menit.';

                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json([
                            'message' => $message,
                        ], 429, $headers);
                    }

                    return back()
                        ->withInput()
                        ->with('contact_error', $message)
                        ->setStatusCode(429);
                });
        });
    }
}
