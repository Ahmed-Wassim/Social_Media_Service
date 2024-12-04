<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweet extends Model
{
    use Sluggable, HasFactory;

    protected $fillable = ['user_id', 'body'];


    // public static function booted()
    // {
    //     static::creating(function (Tweet $tweet) {
    //         $tweet->user_id = Auth::user()->id;
    //     });
    // }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'body'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function likes()
    {
        return $this->belongsToMany(User::class, 'like_tweets')->withTimestamps();
    }
}
