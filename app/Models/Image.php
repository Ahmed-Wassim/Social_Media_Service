<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Image extends Model
{
    protected $fillable = [
        'path'
    ];

    protected function path(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                    return $value;
                } else {
                    return asset('storage/' . $value);
                }
            },
        );
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
