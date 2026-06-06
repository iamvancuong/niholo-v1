<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSection extends Model
{
    //
    protected $fillable = ['exam_id', 'type', 'duration_minutes'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'section_id');
    }
}
