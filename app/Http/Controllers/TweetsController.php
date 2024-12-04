<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Services\TweetService;

class TweetsController extends Controller
{

    public function __construct(
        protected TweetService $service
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        return $this->service->show($tweet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {

        return $this->service->update($request, $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        return $this->service->destroy($tweet);
    }
}
