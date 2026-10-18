<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'name',
        'rating',
        'message',
        'is_visible',
        'is_verified_member',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_visible' => 'boolean',
            'is_verified_member' => 'boolean',
        ];
    }
}
