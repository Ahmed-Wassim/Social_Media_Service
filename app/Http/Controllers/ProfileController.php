<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function __invoke(User $user)
    {
        // Define cache key
        $cacheKey = "profile_{$user->id}_data";

        // Check if the profile data is cached
        $profileData = Cache::get($cacheKey);

        // If not cached, fetch the data
        if (!$profileData) {
            $tweets = $user->tweets()
                ->withCount('likes')
                ->with([
                    'comments' => function ($query) {
                        $query->latest()->take(3);
                    }
                ])
                ->latest()
                ->paginate(8);

            $userData = $user->loadCount(['followers', 'followings']);

            // Prepare the data to be cached
            $profileData = [
                'user' => $user,
                'tweets' => $tweets,
                'followersCount' => $userData->followers_count,
                'followingsCount' => $userData->followings_count,
            ];

            // Cache the data for 10 minutes
            Cache::put($cacheKey, $profileData, now()->addMinutes(4));
        }

        // Return the cached or freshly fetched data
        return response()->json($profileData);
    }
}
