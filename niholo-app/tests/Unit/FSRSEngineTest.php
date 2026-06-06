<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\FSRS\FSRSEngine;
use App\Models\UserReview;
use Carbon\Carbon;

class FSRSEngineTest extends TestCase
{
    public function test_fsrs_calculates_correct_next_review_for_new_card()
    {
        $engine = new FSRSEngine();
        $review = new UserReview([
            'state' => FSRSEngine::STATE_NEW,
        ]);
        
        $now = Carbon::now();
        
        // Rating Good = 3
        $result = $engine->review($review, FSRSEngine::RATING_GOOD, $now);
        
        $this->assertEquals(FSRSEngine::STATE_REVIEW, $result['state']);
        $this->assertEquals(1, $result['reps']);
        $this->assertEquals(0, $result['lapses']);
        
        // It shouldn't be null
        $this->assertNotNull($result['stability']);
        $this->assertNotNull($result['difficulty']);
        $this->assertNotNull($result['next_review_at']);
        
        // First good review -> should add some days (interval should be calculated from stability)
        $this->assertTrue($result['next_review_at']->greaterThan($now));
    }
    
    public function test_fsrs_learning_again_returns_learning_state()
    {
        $engine = new FSRSEngine();
        $review = new UserReview([
            'state' => FSRSEngine::STATE_NEW,
        ]);
        
        $now = Carbon::now();
        
        // Rating Again = 1
        $result = $engine->review($review, FSRSEngine::RATING_AGAIN, $now);
        
        $this->assertEquals(FSRSEngine::STATE_LEARNING, $result['state']);
        $this->assertEquals(1, $result['reps']);
        
        // For Again on new, next review should be in minutes, not days
        // Our hardcoded rule: Again -> +1 min
        $this->assertTrue($result['next_review_at']->diffInMinutes($now) <= 1);
    }
}
