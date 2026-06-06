<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    //
    protected $fillable = ['title', 'level', 'is_published'];

    public function sections()
    {
        return $this->hasMany(ExamSection::class);
    }
}
