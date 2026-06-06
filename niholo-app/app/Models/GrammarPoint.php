<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarPoint extends Model
{
    //

    protected $guarded = [];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function exampleSentences()
    {
        return $this->hasMany(ExampleSentence::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
