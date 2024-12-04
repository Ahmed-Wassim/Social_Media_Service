<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('tweet.delete', function (User $user, Tweet $tweet) {
            return $user->id !== $tweet->user_id;
        });
        Gate::define('tweet.update', function (User $user, Tweet $tweet) {
            return $user->id !== $tweet->user_id;
        });
    }
}
