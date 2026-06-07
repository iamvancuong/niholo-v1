<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/shadowing', function () {
    return Inertia::render('Shadowing');
})->middleware(['auth', 'verified'])->name('shadowing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $stat = $user->stat;
        $leaderboard = app(\App\Services\GamificationService::class)->getWeeklyLeaderboard(10);
        
        $totalCardsN5 = \App\Models\Card::whereIn('type', ['vocabulary', 'kanji'])->count();
        $totalGrammarN5 = \App\Models\Card::where('type', 'grammar')->count();
        
        $learnedCards = \App\Models\UserReview::where('user_id', $user->id)
            ->whereHas('card', function ($q) {
                $q->whereIn('type', ['vocabulary', 'kanji']);
            })->count();
            
        $learnedGrammar = \App\Models\UserReview::where('user_id', $user->id)
            ->whereHas('card', function ($q) {
                $q->where('type', 'grammar');
            })->count();

        return Inertia::render('Dashboard', [
            'userStat' => $stat,
            'leaderboard' => $leaderboard,
            'progress' => [
                'totalCardsN5' => $totalCardsN5,
                'totalGrammarN5' => $totalGrammarN5,
                'learnedCards' => $learnedCards,
                'learnedGrammar' => $learnedGrammar,
            ]
        ]);
    })->name('dashboard');

    // Suspended Cards Vault
    Route::get('/vault', [\App\Http\Controllers\SuspendedCardController::class, 'index'])->name('vault.index');
    Route::post('/vault/reviews/{review}/unsuspend', [\App\Http\Controllers\SuspendedCardController::class, 'unsuspend'])->name('vault.unsuspend');
    
    Route::get('/leech-quarantine', function () {
        return redirect()->route('vault.index', ['tab' => 'leech']);
    })->name('leech.index');
});

// Leaderboard Web
Route::get('/leaderboard', [\App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard.index');

// Learning Routes (Public for Invisible Onboarding)
Route::get('/exams', [\App\Http\Controllers\ExamController::class, 'index'])->name('exams.index');
Route::get('/exams/{exam}', [\App\Http\Controllers\ExamController::class, 'show'])->name('exams.show');
Route::get('/exams/{exam}/take', [\App\Http\Controllers\ExamController::class, 'take'])->name('exams.take');
Route::post('/exams/{exam}/submit', [\App\Http\Controllers\ExamController::class, 'submit'])->name('exams.submit');
Route::get('/exams/results/{attempt}', [\App\Http\Controllers\ExamController::class, 'result'])->name('exams.result');
Route::get('/courses', [\App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [\App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{course}/{category}', [\App\Http\Controllers\LessonController::class, 'index'])->name('lessons.index');

// Theory Routes
Route::get('/lessons/{lesson}/vocabulary', [\App\Http\Controllers\VocabularyController::class, 'theory'])->name('vocabulary.theory');
Route::get('/lessons/{lesson}/grammar', [\App\Http\Controllers\GrammarController::class, 'theory'])->name('grammar.theory');
Route::get('/lessons/{lesson}/kanji', [\App\Http\Controllers\KanjiController::class, 'theory'])->name('kanji.theory');

// Study & Reviews (Public, progress saved to localStorage for guests)
Route::get('/lessons/{lesson}/study', [\App\Http\Controllers\StudyController::class, 'session'])->name('study.session');

// Keep old route if any puzzle or other thing uses it temporarily, but we won't use it in Session.vue
Route::post('/cards/{card}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

// Grammar & Puzzles
Route::get('/lessons/{lesson}/puzzle/{card}', [\App\Http\Controllers\PuzzleController::class, 'show'])->name('puzzle.show');
Route::post('/lessons/{lesson}/puzzle/{card}/submit', [\App\Http\Controllers\PuzzleController::class, 'submit'])->name('puzzle.submit');

// Leaderboard API
Route::get('/api/leaderboard', [\App\Http\Controllers\LeaderboardController::class, 'weekly'])->name('api.leaderboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
