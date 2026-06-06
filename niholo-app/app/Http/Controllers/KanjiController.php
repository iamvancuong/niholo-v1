<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KanjiController extends Controller
{
    public function theory(Lesson $lesson)
    {
        $kanjis = $lesson->kanjis()->with('cards')->get();

        return Inertia::render('Kanji/Theory', [
            'lesson' => $lesson,
            'kanjis' => $kanjis
        ]);
    }
}
