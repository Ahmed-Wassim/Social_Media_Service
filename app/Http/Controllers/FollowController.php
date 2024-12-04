<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\FollowedNotification;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        $follower = auth()->user();

        // Check if the user is already following the target user
        if ($follower->follows($user)) {
            return response()->error(
                'You are already following this user.',
                400
            );
        }

        // Attach the follower
        $follower->followings()->attach($user);

        $user->notify(new FollowedNotification($follower));

        return response()->success('User followed successfully.');
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();

        // Check if the user is actually following the target user
        if (!$follower->follows($user)) {
            return response()->error(
                'You are not following this user.',
                400
            );
        }

        // Detach the follower
        $follower->followings()->detach($user);

        return response()->success('User unfollowed successfully.');
    }
}
