<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Tweet $tweet)
    {
        $liker = Auth::user();

        // Check if the user has already liked the tweet
        if ($liker->likesTweet($tweet)) {
            return response()->error(
                'You have already liked this tweet.',
                400
            );
        }

        // Attach the like
        $liker->likes()->attach($tweet);

        return response()->success('Tweet liked successfully.');
    }

    public function unlike(Tweet $tweet)
    {
        $liker = Auth::user();

        // Check if the user has liked the tweet
        if (!$liker->likesTweet($tweet)) {
            return response()->error(
                'You have not liked this tweet.',
                400
            );
        }
        // Detach the like
        $liker->likes()->detach($tweet);

        return response()->success('Tweet unliked successfully.');
    }
}
