<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TimeLineController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = Auth::id();
        $cacheKey = "timeline_{$userId}_tweets";

        // Check if the timeline data is cached
        $tweets = Cache::get($cacheKey);

        // If not cached, fetch the data
        if (!$tweets) {
            $followingsIds = Auth::user()->followings()->pluck('user_id');

            $tweets = Tweet::whereIn('user_id', $followingsIds)
                ->withCount('likes', 'comments')
                ->with(['user', 'comments' => function ($query) {
                    $query->latest()->take(3);
                }])
                ->latest()
                ->paginate(8);

            // Cache the data for 10 minutes
            Cache::put($cacheKey, $tweets, now()->addMinutes(10));
        }

        // Return the cached or freshly fetched data
        return response()->success($tweets);
    }
}
