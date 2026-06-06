<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\UserReview;
use App\Services\FSRS\FSRSEngine;
use App\Services\GamificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudySessionController extends Controller
{
    public function finish(Request $request, GamificationService $gamificationService)
    {
        $validated = $request->validate([
            'results' => 'required|array',
            'results.*.card_id' => 'required|integer',
            'results.*.rating' => 'nullable|integer|min:1|max:4',
            'results.*.suspend' => 'nullable|boolean',
            'results.*.duration_ms' => 'nullable|integer',
            'results.*.current_state' => 'nullable|array', // For guests
        ]);

        $user = Auth::user();
        $now = Carbon::now();
        $engine = new FSRSEngine();
        
        $totalXpEarned = 0;
        $guestReviewsToReturn = [];

        DB::beginTransaction();
        try {
            foreach ($validated['results'] as $resultData) {
                $cardId = $resultData['card_id'];
                $rating = $resultData['rating'];
                
                $review = UserReview::firstOrNew([
                    'user_id' => $user ? $user->id : null,
                    'card_id' => $cardId,
                ]);

                if (!$user && isset($resultData['current_state'])) {
                    $review->fill($resultData['current_state']);
                }

                $isNew = !$review->exists;
                
                // Handle manual suspend
                if (isset($resultData['suspend']) && $resultData['suspend'] === true) {
                    $review->is_suspended = true;
                    if ($user) {
                        $review->save();
                    }
                    continue; // Skip FSRS update
                }

                $result = $engine->review($review, $rating, $now);

                $review->state = $result['state'];
                $review->difficulty = $result['difficulty'];
                $review->stability = $result['stability'];
                $review->reps = $result['reps'];
                $review->lapses = $result['lapses'];
                $review->elapsed_days = $result['elapsed_days'];
                $review->scheduled_days = $result['scheduled_days'];
                $review->last_review_at = $result['last_review_at'];
                $review->next_review_at = $result['next_review_at'];
                
                // Leech Quarantine Logic
                if ($review->lapses >= 5) {
                    $review->is_leech = true;
                    $review->is_suspended = true;
                }
                
                if ($user) {
                    $review->save();
                    // Accumulate XP
                    $totalXpEarned += ($isNew ? 3 : 1);
                } else {
                    // Collect for local storage
                    $guestReviewsToReturn[$cardId] = $review->toArray();
                }
            }

            if ($user && $totalXpEarned > 0) {
                $gamificationService->awardXp($user, $totalXpEarned);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'total_xp_earned' => $totalXpEarned,
                'guest_reviews' => $guestReviewsToReturn,
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error finishing study session: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi lưu kết quả học tập.'
            ], 500);
        }
    }
}
