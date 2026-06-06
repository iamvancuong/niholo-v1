<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'example_blocks_json' => 'array',
        ];
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function exampleSentences()
    {
        return $this->hasMany(ExampleSentence::class);
    }

    public function userReviews()
    {
        return $this->hasMany(UserReview::class);
    }

    public function grammarPoint()
    {
        return $this->belongsTo(GrammarPoint::class);
    }

    public function kanjis()
    {
        return $this->belongsToMany(Kanji::class);
    }
}
