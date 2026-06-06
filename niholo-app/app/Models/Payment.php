<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $guarded = [];
    protected $casts = [
        'payload_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
