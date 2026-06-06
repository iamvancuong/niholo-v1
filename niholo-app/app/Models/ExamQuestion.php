<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'mondai_number',
        'instruction',
        'passage',
        'image_url',
        'audio_url',
        'audio_timestamp',
        'text',
        'options_json',
        'correct_option_id',
    ];

    protected $casts = [
        'options_json' => 'array',
    ];

    public function section()
    {
        return $this->belongsTo(ExamSection::class, 'section_id');
    }
}
