<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GrammarController extends Controller
{
    public function theory(Lesson $lesson)
    {
        $grammarPoints = $lesson->grammarPoints()->with(['cards' => function($q) {
            $q->where('type', 'grammar');
        }])->get();

        return Inertia::render('Grammar/Theory', [
            'lesson' => $lesson,
            'grammarPoints' => $grammarPoints
        ]);
    }
}
