<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    //

    protected $guarded = [];
    protected $casts = [
        'is_leech' => 'boolean',
        'is_suspended' => 'boolean',
        'last_review_at' => 'datetime',
        'next_review_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
