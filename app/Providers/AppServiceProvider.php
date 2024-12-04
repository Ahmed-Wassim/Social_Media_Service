<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;


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

        Response::macro('success', function ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        });

        Response::macro('created', function ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Created successfully',
                'data' => $data,
            ], 201);
        });

        Response::macro('error', function ($error, $code) {
            return response()->json([
                'success' => false,
                'error' => $error,
            ], $code);
        });
    }
}
