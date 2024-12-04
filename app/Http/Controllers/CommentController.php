<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __invoke(Tweet $tweet)
    {
        request()->validate([
            'body' => 'required'
        ]);

        Comment::create([
            'user_id' => Auth::user()->id,
            'tweet_id' => $tweet->id,
            'body' => request()->get('body')
        ]);

        return response()->success('Comment created successfully');
    }
}
