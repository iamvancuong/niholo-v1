<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserReview;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class LessonController extends Controller
{
    public function index(Course $course, string $category)
    {
        $user = Auth::user();
        $now = Carbon::now();

        $lessons = $course->lessons()
            ->where('category', $category)
            ->withCount(['cards', 'grammarPoints'])
            ->with(['cards' => function($query) {
                $query->whereNotNull('example_blocks_json')->select('id', 'lesson_id')->limit(1);
            }])
            ->get();

        // Tính số thẻ cần ôn cho mỗi bài học
        foreach ($lessons as $lesson) {
            $cardIds = $lesson->cards()->pluck('id');
            $totalCards = $lesson->cards_count;
            
            if ($user) {
                // Lấy review của user cho các card trong bài này
                $reviews = UserReview::where('user_id', $user->id)
                    ->whereIn('card_id', $cardIds)
                    ->get()
                    ->keyBy('card_id');

                $dueCount = 0;
                
                foreach ($cardIds as $cardId) {
                    $review = $reviews->get($cardId);
                    if (!$review || Carbon::parse($review->next_review_at)->lte($now)) {
                        $dueCount++;
                    }
                }
            } else {
                // Khách chưa có dữ liệu trong DB, mặc định mọi thẻ đều có thể học
                $dueCount = $totalCards;
            }

            $lesson->due_cards_count = $dueCount;
        }

        return Inertia::render('Lessons/Index', [
            'course' => $course,
            'category' => $category,
            'lessons' => $lessons
        ]);
    }
}
