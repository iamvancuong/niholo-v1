<?php

namespace App\Services\FSRS;

use Carbon\Carbon;
use App\Models\UserReview;

class FSRSEngine
{
    // Default FSRS v4 parameters
    protected array $w = [
        0.4, 0.6, 1.4, 2.4, 4.93, 0.94, 0.86, 0.01,
        1.49, 0.14, 0.94, 2.18, 0.05, 0.34, 1.26, 0.29, 2.61
    ];

    protected float $requestRetention = 0.9;
    protected int $maximumInterval = 36500;

    /**
     * Constants for Rating
     */
    public const RATING_AGAIN = 1;
    public const RATING_HARD = 2;
    public const RATING_GOOD = 3;
    public const RATING_EASY = 4;

    /**
     * Constants for State
     */
    public const STATE_NEW = 0;
    public const STATE_LEARNING = 1;
    public const STATE_REVIEW = 2;
    public const STATE_RELEARNING = 3;

    public function __construct(array $w = null, float $requestRetention = 0.9)
    {
        if ($w !== null) {
            $this->w = $w;
        }
        $this->requestRetention = $requestRetention;
    }

    /**
     * Process a review and return updated review data.
     */
    public function review(UserReview $review, int $rating, Carbon $reviewAt): array
    {
        $state = $review->state ?? self::STATE_NEW;
        $difficulty = $review->difficulty ?? 0.0;
        $stability = $review->stability ?? 0.0;
        $reps = $review->reps ?? 0;
        $lapses = $review->lapses ?? 0;
        $lastReviewAt = $review->last_review_at ? Carbon::parse($review->last_review_at) : $reviewAt;

        // Calculate days since last review
        $elapsedDays = $state === self::STATE_NEW ? 0 : max(0, $reviewAt->diffInDays($lastReviewAt));

        $newReps = $reps + 1;
        $newLapses = $lapses;

        // Initialize new values
        $newStability = $stability;
        $newDifficulty = $difficulty;
        $newState = $state;

        if ($state === self::STATE_NEW) {
            $newDifficulty = $this->initDifficulty($rating);
            $newStability = $this->initStability($rating);
            
            if ($rating === self::RATING_EASY) {
                $newState = self::STATE_REVIEW;
            } else {
                $newState = self::STATE_LEARNING;
            }
        } elseif ($state === self::STATE_LEARNING || $state === self::STATE_RELEARNING) {
            $newDifficulty = $this->nextDifficulty($difficulty, $rating);
            $newStability = $this->shortTermStability($stability, $rating);
            
            if ($rating === self::RATING_GOOD || $rating === self::RATING_EASY) {
                $newState = self::STATE_REVIEW;
            } else {
                $newState = $state; // stays in learning/relearning
            }
        } elseif ($state === self::STATE_REVIEW) {
            $newDifficulty = $this->nextDifficulty($difficulty, $rating);
            
            if ($rating === self::RATING_AGAIN) {
                $newLapses = $lapses + 1;
                $newStability = $this->nextForgetStability($newDifficulty, $stability, $elapsedDays);
                $newState = self::STATE_RELEARNING;
            } else {
                $newStability = $this->nextRecallStability($newDifficulty, $stability, $elapsedDays, $rating);
                $newState = self::STATE_REVIEW;
            }
        }

        // Calculate Next Interval
        $interval = $this->nextInterval($newStability);
        
        // Hard-code intervals for Learning/Relearning for simplicity (in minutes)
        // If state is not review, next interval is very short
        if ($newState === self::STATE_LEARNING || $newState === self::STATE_RELEARNING) {
            if ($rating === self::RATING_AGAIN) {
                $nextReviewAt = $reviewAt->copy()->addMinutes(1);
            } elseif ($rating === self::RATING_HARD) {
                $nextReviewAt = $reviewAt->copy()->addMinutes(5);
            } elseif ($rating === self::RATING_GOOD) {
                $nextReviewAt = $reviewAt->copy()->addMinutes(30);
            } else {
                $nextReviewAt = $reviewAt->copy()->addMinutes(60);
            }
            $interval = 0; // 0 days
        } else {
            // State is Review
            if ($state === self::STATE_NEW && $rating === self::RATING_EASY) {
                $interval = 1; // Force 1 day for first Easy
            }
            $nextReviewAt = $reviewAt->copy()->addDays($interval);
        }

        return [
            'state' => $newState,
            'difficulty' => round($newDifficulty, 4),
            'stability' => round($newStability, 4),
            'reps' => $newReps,
            'lapses' => $newLapses,
            'elapsed_days' => $elapsedDays,
            'scheduled_days' => $interval,
            'last_review_at' => $reviewAt,
            'next_review_at' => $nextReviewAt,
        ];
    }

    private function initStability(int $rating): float
    {
        return max(0.1, $this->w[$rating - 1]);
    }

    private function initDifficulty(int $rating): float
    {
        return min(max($this->w[4] - $this->w[5] * ($rating - 3), 1), 10);
    }

    private function nextDifficulty(float $d, int $rating): float
    {
        $nextD = $d - $this->w[6] * ($rating - 3);
        return min(max($this->meanReversion($this->w[4], $nextD), 1), 10);
    }

    private function meanReversion(float $init, float $current): float
    {
        return $this->w[7] * $init + (1 - $this->w[7]) * $current;
    }

    private function shortTermStability(float $s, int $rating): float
    {
        return $s * exp($this->w[16] * ($rating - 3 + 0.1));
    }

    private function nextRecallStability(float $d, float $s, int $r, int $rating): float
    {
        $hardPenalty = $rating === self::RATING_HARD ? $this->w[15] : 1;
        $easyBonus = $rating === self::RATING_EASY ? $this->w[16] : 1;
        return $s * (1 + exp($this->w[8]) * 
            (11 - $d) * 
            pow($s, -$this->w[9]) * 
            (exp((1 - $this->requestRetention) * $this->w[10]) - 1) *
            $hardPenalty * $easyBonus);
    }

    private function nextForgetStability(float $d, float $s, int $r): float
    {
        return $this->w[11] * 
            pow($d, -$this->w[12]) * 
            (pow($s + 1, $this->w[13]) - 1) * 
            exp($this->w[14] * (1 - $this->requestRetention));
    }

    private function nextInterval(float $s): int
    {
        $interval = (int) round($s * 9 * (1 / $this->requestRetention - 1));
        return min(max($interval, 1), $this->maximumInterval);
    }
}
