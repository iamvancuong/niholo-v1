<?php

namespace Tests\Feature\Study;

use App\Models\Card;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserReview;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeechQuarantineTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $card;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        
        $course = \App\Models\Course::create([
            'level' => 'N5',
            'name' => 'Test Course',
            'description' => 'Test',
            'is_published' => true,
        ]);
        
        $lesson = \App\Models\Lesson::create([
            'course_id' => $course->id,
            'title' => 'Test Lesson',
            'category' => 'vocabulary',
            'order_index' => 1,
            'is_published' => true,
        ]);

        $this->card = \App\Models\Card::create([
            'lesson_id' => $lesson->id,
            'type' => 'vocabulary',
            'front_text' => 'A',
            'back_text' => 'B',
            'reading' => 'C',
        ]);
    }

    public function test_card_with_less_than_four_lapses_does_not_become_leech()
    {
        // Setup existing review with 3 lapses
        UserReview::create([
            'user_id' => $this->user->id,
            'card_id' => $this->card->id,
            'lapses' => 3,
            'state' => 2,
            'difficulty' => 0.5,
            'stability' => 1.0,
            'reps' => 5,
            'elapsed_days' => 0,
            'scheduled_days' => 0,
        ]);

        $response = $this->actingAs($this->user)->postJson(route('study.finish-session'), [
            'results' => [
                [
                    'card_id' => $this->card->id,
                    'rating' => 1, // Wrong answer
                ]
            ]
        ]);

        $response->assertStatus(200);

        $review = UserReview::where('user_id', $this->user->id)->where('card_id', $this->card->id)->first();
        
        $this->assertEquals(4, $review->lapses);
        $this->assertFalse((bool) $review->is_leech);
        $this->assertFalse((bool) $review->is_suspended);
    }

    public function test_card_with_four_lapses_becomes_leech_on_next_lapse()
    {
        // Setup existing review with 4 lapses
        UserReview::create([
            'user_id' => $this->user->id,
            'card_id' => $this->card->id,
            'lapses' => 4,
            'state' => 2,
            'difficulty' => 0.5,
            'stability' => 1.0,
            'reps' => 6,
            'elapsed_days' => 0,
            'scheduled_days' => 0,
        ]);

        $response = $this->actingAs($this->user)->postJson(route('study.finish-session'), [
            'results' => [
                [
                    'card_id' => $this->card->id,
                    'rating' => 1, // Wrong answer again (5th lapse)
                ]
            ]
        ]);

        $response->assertStatus(200);

        $review = UserReview::where('user_id', $this->user->id)->where('card_id', $this->card->id)->first();
        
        $this->assertEquals(5, $review->lapses);
        $this->assertTrue((bool) $review->is_leech);
        $this->assertTrue((bool) $review->is_suspended);
    }

    public function test_correct_review_does_not_increase_lapses()
    {
        // Setup existing review with 4 lapses
        UserReview::create([
            'user_id' => $this->user->id,
            'card_id' => $this->card->id,
            'lapses' => 4,
            'state' => 2,
            'difficulty' => 0.5,
            'stability' => 1.0,
            'reps' => 6,
            'elapsed_days' => 0,
            'scheduled_days' => 0,
        ]);

        $response = $this->actingAs($this->user)->postJson(route('study.finish-session'), [
            'results' => [
                [
                    'card_id' => $this->card->id,
                    'rating' => 3, // Correct answer
                ]
            ]
        ]);

        $response->assertStatus(200);

        $review = UserReview::where('user_id', $this->user->id)->where('card_id', $this->card->id)->first();
        
        $this->assertEquals(4, $review->lapses); // Lapses stay the same
        $this->assertFalse((bool) $review->is_leech);
        $this->assertFalse((bool) $review->is_suspended);
    }
}
