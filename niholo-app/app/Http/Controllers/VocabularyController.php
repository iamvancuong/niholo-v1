<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VocabularyController extends Controller
{
    /**
     * Show vocabulary theory (list of all words).
     */
    public function theory(Lesson $lesson)
    {
        $lesson->load(['course', 'cards' => function ($query) {
            $query->where('type', 'vocabulary');
        }]);

        return Inertia::render('Vocabulary/Theory', [
            'lesson' => $lesson
        ]);
    }
}
