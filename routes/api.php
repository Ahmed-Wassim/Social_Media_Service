<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\TweetsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeLineController;

// Auth Routes
Route::group(
    [
        'prefix' => 'auth'
    ],
    function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
        Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware('auth:api');
    }
);

Route::get('/profile/{user}', ProfileController::class);

//End of Auth and profile


Route::apiResource('/tweets', TweetsController::class)->except('index');

//comment of tweet

Route::post('tweets/{tweet}/comment', CommentController::class);

//follows routes

Route::post('/users/{user}/follow', [FollowController::class, 'follow'])->middleware('auth:api');

Route::post('/users/{user}/unfollow', [FollowController::class, 'unfollow'])->middleware('auth:api');


//likes routes
Route::post('/tweets/{tweet}/like', [LikeController::class, 'like'])->middleware('auth:api');

Route::post('/tweets/{tweet}/unlike', [LikeController::class, 'unlike'])->middleware('auth:api');

//timeline route

Route::get('timeline', TimeLineController::class)->middleware('auth:api');
