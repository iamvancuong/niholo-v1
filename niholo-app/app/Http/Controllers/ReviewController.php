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
            'rating' => 'nullable|integer|min:1|max:4',
            'suspend' => 'nullable|boolean',
            'duration_ms' => 'nullable|integer',
            'current_state' => 'nullable|array',
        ]);

        $user = Auth::user();
        $now = Carbon::now();

        $review = UserReview::firstOrNew([
            'user_id' => $user ? $user->id : null,
            'card_id' => $card->id,
        ]);

        if (!$user && isset($validated['current_state'])) {
            $review->fill($validated['current_state']);
        }

        $isNew = !$review->exists;

        // Handle suspend
        if (isset($validated['suspend']) && $validated['suspend'] === true) {
            $review->is_suspended = true;
            if ($user) {
                $review->save();
            }
            return response()->json([
                'success' => true,
                'review' => $review,
                'xp_earned' => 0
            ]);
        }

        if (!isset($validated['rating'])) {
            return response()->json(['success' => false, 'message' => 'Rating is required'], 422);
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

        // Auto-Unsuspend Logic (If reviewing a suspended card with Good/Easy)
        if ($review->is_suspended && $validated['rating'] >= 3) {
            $review->is_suspended = false;
            $review->is_leech = false;
            $review->lapses = 0; // Reset lapses to prevent immediate re-leeching
        }

        // Leech Quarantine Logic
        if ($review->lapses >= 5) {
            $review->is_leech = true;
            $review->is_suspended = true;
        }
        
        $xpAmount = 0;
        if ($user) {
            $review->save();

            // Gamification hook
            $xpAmount = $isNew ? 3 : 1; // 3 XP for new card, 1 XP for review
            $gamificationService = app(\App\Services\GamificationService::class);
            $stat = $gamificationService->awardXp($user, $xpAmount);
        }

        return response()->json([
            'success' => true,
            'review' => $review,
            'xp_earned' => $xpAmount
        ]);
    }
}
