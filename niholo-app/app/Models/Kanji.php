<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanji extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'character',
        'sino_vietnamese',
        'meaning',
        'onyomi',
        'kunyomi',
        'stroke_count',
        'jlpt_level',
        'mnemonic'
    ];

    protected $casts = [
        'onyomi' => 'array',
        'kunyomi' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }
}
