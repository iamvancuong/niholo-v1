<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\UserExamAttempt;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('is_published', true)->get();
        return Inertia::render('Exams/Index', [
            'exams' => $exams
        ]);
    }

    public function show($id)
    {
        $exam = Exam::with('sections')->findOrFail($id);
        
        $totalDuration = $exam->sections->sum('duration_minutes');
        
        // Get previous attempts
        $attempts = UserExamAttempt::where('user_id', auth()->id())
            ->where('exam_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Exams/Show', [
            'exam' => $exam,
            'totalDuration' => $totalDuration,
            'attempts' => $attempts
        ]);
    }

    public function take($id)
    {
        $exam = Exam::with(['sections.questions'])->findOrFail($id);
        $totalDuration = $exam->sections->sum('duration_minutes');

        // To keep the test strictly timed and prevent reload cheating, 
        // normally we'd create an attempt here, but for a mock test, client-side is fine for now.

        return Inertia::render('Exams/Take', [
            'exam' => $exam,
            'totalDuration' => $totalDuration
        ]);
    }

    public function submit(Request $request, $id)
    {
        $exam = Exam::with(['sections.questions'])->findOrFail($id);
        
        $answers = $request->input('answers', []); // format: { question_id: selected_option_id }

        $totalScore = 0;
        $maxScore = 0;
        $sectionScores = [];

        foreach ($exam->sections as $section) {
            $sectionScore = 0;
            $sectionMax = 0;

            foreach ($section->questions as $question) {
                // In a real JLPT, scores are scaled and weighted. 
                // For this mock test, we'll assign 1 point per correct answer.
                $sectionMax++;
                $maxScore++;

                $userAnswerId = $answers[$question->id] ?? null;
                if ($userAnswerId == $question->correct_option_id) {
                    $sectionScore++;
                    $totalScore++;
                }
            }

            $sectionScores[$section->type] = [
                'score' => $sectionScore,
                'max' => $sectionMax
            ];
        }

        $attempt = UserExamAttempt::create([
            'user_id' => auth()->id(),
            'exam_id' => $exam->id,
            'score' => $totalScore,
            'total_score' => $maxScore,
            'answers_json' => $answers,
            'section_scores_json' => $sectionScores,
            'completed_at' => now(),
        ]);

        return redirect()->route('exams.result', $attempt->id);
    }

    public function result($attemptId)
    {
        $attempt = UserExamAttempt::with(['exam.sections.questions'])->findOrFail($attemptId);
        
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Exams/Result', [
            'attempt' => $attempt
        ]);
    }
}
