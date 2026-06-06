<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExamAttempt extends Model
{
    //
    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
        'total_score',
        'answers_json',
        'section_scores_json',
        'completed_at',
    ];

    protected $casts = [
        'answers_json' => 'array',
        'section_scores_json' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
