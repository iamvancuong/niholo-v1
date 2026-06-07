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
            ->orderBy('order_index')
            ->withCount(['cards', 'grammarPoints'])
            ->with(['cards' => function($query) {
                $query->whereNotNull('example_blocks_json')->select('id', 'lesson_id')->limit(1);
            }])
            ->get();

        $lessonIds = $lessons->pluck('id');
        
        // Lấy tất cả card_ids của các lessons này để giảm thiểu N+1
        $allCards = \App\Models\Card::whereIn('lesson_id', $lessonIds)->select('id', 'lesson_id')->get();
        $cardsByLesson = $allCards->groupBy('lesson_id');
        
        if ($user) {
            $reviews = UserReview::where('user_id', $user->id)
                ->whereIn('card_id', $allCards->pluck('id'))
                ->get()
                ->keyBy('card_id');
        }

        // Tính số thẻ cần ôn cho mỗi bài học
        foreach ($lessons as $lesson) {
            $lessonCards = $cardsByLesson->get($lesson->id, collect());
            $totalCards = $lesson->cards_count;
            
            if ($user) {
                $dueCount = 0;
                foreach ($lessonCards as $card) {
                    $review = $reviews->get($card->id);
                    
                    if ($review && $review->is_suspended) {
                        continue;
                    }

                    if (!$review || Carbon::parse($review->next_review_at)->lte($now)) {
                        $dueCount++;
                    }
                }
            } else {
                // Khách chưa có dữ liệu trong DB, frontend sẽ tính lại từ localStorage
                $dueCount = $totalCards;
            }

            // Gắn card_ids để frontend của guest có thể tính toán lại
            $lesson->all_card_ids = $lessonCards->pluck('id')->toArray();
            $lesson->due_cards_count = $dueCount;
        }

        return Inertia::render('Lessons/Index', [
            'course' => $course,
            'category' => $category,
            'lessons' => $lessons
        ]);
    }
}
