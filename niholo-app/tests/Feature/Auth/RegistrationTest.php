<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = \App\Models\User::where('email', 'test@example.com')->first();
        $this->assertTrue($user->hasRole('guest'));
    }

    public function test_new_users_can_register_and_merge_guest_reviews(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $guestReviewsPayload = [
            '10' => [ // Card ID 10
                'state' => 1,
                'difficulty' => 5.5,
                'stability' => 0.5,
                'reps' => 1,
                'lapses' => 0,
                'elapsed_days' => 0,
                'scheduled_days' => 1,
                'last_review_at' => now()->toISOString(),
                'next_review_at' => now()->addDay()->toISOString(),
            ],
            '15' => [ // Card ID 15
                'state' => 2,
                'difficulty' => 4.5,
                'stability' => 1.2,
                'reps' => 2,
                'lapses' => 0,
                'elapsed_days' => 1,
                'scheduled_days' => 3,
                'last_review_at' => now()->toISOString(),
                'next_review_at' => now()->addDays(3)->toISOString(),
            ]
        ];

        $response = $this->post('/register', [
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'guest_reviews' => $guestReviewsPayload,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = \App\Models\User::where('email', 'test2@example.com')->first();
        
        // Assert reviews were saved
        $reviews = \App\Models\UserReview::where('user_id', $user->id)->get();
        $this->assertCount(2, $reviews);

        $this->assertDatabaseHas('user_reviews', [
            'user_id' => $user->id,
            'card_id' => 10,
            'reps' => 1,
        ]);

        $this->assertDatabaseHas('user_reviews', [
            'user_id' => $user->id,
            'card_id' => 15,
            'reps' => 2,
        ]);
    }
}
