<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExampleSentence extends Model
{
    //

    protected $guarded = [];
    protected $casts = [
        'furigana_json' => 'array',
        'is_real_voice' => 'boolean',
    ];

    public function grammarPoint()
    {
        return $this->belongsTo(GrammarPoint::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
