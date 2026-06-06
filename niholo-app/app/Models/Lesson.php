<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function grammarPoints()
    {
        return $this->hasMany(GrammarPoint::class);
    }

    public function kanjis()
    {
        return $this->hasMany(Kanji::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
