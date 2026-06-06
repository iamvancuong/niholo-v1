<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\UserReview;
use App\Services\FSRS\FSRSEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request, Card $card)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:4',
            'duration_ms' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $now = Carbon::now();

        $review = UserReview::firstOrNew([
            'user_id' => $user ? $user->id : null,
            'card_id' => $card->id,
        ]);

        // If it's a guest, and there's a payload of previous review state in the request,
        // we should initialize the $review object with that state before feeding it to FSRSEngine.
        if (!$user && $request->has('current_state')) {
            $review->fill($request->input('current_state'));
        }

        $engine = new FSRSEngine();
        $result = $engine->review($review, $validated['rating'], $now);

        // Update Review model
        $review->state = $result['state'];
        $review->difficulty = $result['difficulty'];
        $review->stability = $result['stability'];
        $review->reps = $result['reps'];
        $review->lapses = $result['lapses'];
        $review->elapsed_days = $result['elapsed_days'];
        $review->scheduled_days = $result['scheduled_days'];
        $review->last_review_at = $result['last_review_at'];
        $review->next_review_at = $result['next_review_at'];
        
        if ($user) {
            $isNew = !$review->exists;
            $review->save();

            // Gamification hook
            $xpAmount = $isNew ? 3 : 1; // 3 XP for new card, 1 XP for review
            $gamificationService = app(\App\Services\GamificationService::class);
            $stat = $gamificationService->awardXp($user, $xpAmount);
        }

        return response()->json([
            'success' => true,
            'review' => $review,
            'xp_earned' => isset($xpAmount) ? $xpAmount : 0
        ]);
    }
}
