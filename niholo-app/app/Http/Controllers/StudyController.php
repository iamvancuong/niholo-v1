<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Card;
use App\Models\UserReview;
use App\Services\FSRS\FSRSEngine;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class StudyController extends Controller
{
    public function session(Lesson $lesson)
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Eager load cards and their grammar points & kanjis
        $lesson->load('cards.grammarPoint', 'cards.kanjis');
        $cardIds = $lesson->cards->pluck('id');

        // Find due cards: either no review exists, or next_review_at <= now
        if ($user) {
            $reviews = UserReview::where('user_id', $user->id)
                ->whereIn('card_id', $cardIds)
                ->get()->keyBy('card_id');
        } else {
            $reviews = collect();
        }

        $engine = new FSRSEngine();

        $dueCards = [];
        foreach ($lesson->cards as $card) {
            $review = $reviews->get($card->id);
            
            // Skip suspended cards (manual or leech)
            if ($review && $review->is_suspended) {
                continue;
            }

            if (!$review || Carbon::parse($review->next_review_at)->lte($now)) {
                // Compute preview intervals
                $dummyReview = $review ?? new UserReview(['user_id' => $user ? $user->id : null, 'card_id' => $card->id]);
                $nextIntervals = [];
                foreach ([1, 2, 3, 4] as $rating) {
                    $result = $engine->review($dummyReview, $rating, clone $now);
                    if ($result['scheduled_days'] > 0) {
                        $nextIntervals[$rating] = $result['scheduled_days'] . ' ngày';
                    } else {
                        // Hardcoded learning steps from FSRSEngine
                        if ($rating === 1) $nextIntervals[$rating] = '1 phút';
                        elseif ($rating === 2) $nextIntervals[$rating] = '5 phút';
                        else $nextIntervals[$rating] = '10 phút';
                    }
                }

                $dueCards[] = [
                    'card' => $card,
                    'review' => $review,
                    'next_intervals' => $nextIntervals
                ];
            }
        }

        return Inertia::render('Study/Session', [
            'lesson' => $lesson,
            'dueCards' => $dueCards
        ]);
    }
}
