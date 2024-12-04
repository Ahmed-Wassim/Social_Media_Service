<?php

namespace App\Services;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetService
{

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|max:140'
        ]);

        $tweet = Tweet::create([
            'body' => $request->body
        ]);

        return response()->created(TweetResource::make($tweet));
    }

    public function show(Tweet $tweet)
    {
        $tweet->load('user', 'comments.user');
        return response()->success(TweetResource::make($tweet));
    }

    public function update(Request $request, Tweet $tweet)
    {

        $this->authorize('tweet.update', $tweet);
        $request->validate([
            'body' => 'required|max:140'
        ]);

        $tweet->update([
            'body' => $request->body
        ]);

        return response()->success(TweetResource::make($tweet));
    }


    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        return response()->success('tweet deleted successfully');
    }
}
