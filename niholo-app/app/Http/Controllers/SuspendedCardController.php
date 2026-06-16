<?php

namespace App\Http\Controllers;

use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SuspendedCardController extends Controller
{
    /**
     * Show the suspended cards vault.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'leech');
        
        $query = UserReview::with('card.lesson.course')
            ->where('user_id', $user->id)
            ->where('is_suspended', true);

        if ($tab === 'leech') {
            $query->where('is_leech', true);
        } else {
            $query->where('is_leech', false);
        }

        $suspendedReviews = $query->orderBy('updated_at', 'desc')->paginate(20)->withQueryString();

        return Inertia::render('Study/SuspendedCards', [
            'suspendedReviews' => $suspendedReviews,
            'currentTab' => $tab
        ]);
    }

    /**
     * Start a review session for suspended cards.
     */
    public function study(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'leech');
        
        $query = UserReview::with(['card.grammarPoint', 'card.kanjis'])
            ->where('user_id', $user->id)
            ->where('is_suspended', true);

        if ($tab === 'leech') {
            $query->where('is_leech', true);
            $title = 'Thẻ cực khó';
        } else {
            $query->where('is_leech', false);
            $title = 'Thẻ đã thuộc';
        }

        $reviews = $query->orderBy('updated_at', 'desc')->limit(50)->get();
        
        $dueCards = [];
        foreach ($reviews as $review) {
            $dueCards[] = [
                'card' => $review->card,
                'review' => $review,
            ];
        }

        // Fake lesson object for Session.vue header
        $fakeLesson = [
            'id' => 0,
            'course_id' => 0,
            'category' => $tab,
            'title' => $title,
        ];

        return Inertia::render('Study/Session', [
            'lesson' => $fakeLesson,
            'dueCards' => $dueCards,
            'backUrl' => route('vault.index', ['tab' => $tab])
        ]);
    }

    /**
     * Unsuspend a specific card review.
     */
    public function unsuspend(Request $request, UserReview $review)
    {
        // Ensure the review belongs to the user
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->is_suspended = false;
        // Optionally, if they unsuspend a leech, we might want to reset the lapses or leave it
        $review->is_leech = false; 
        $review->save();

        return redirect()->back()->with('success', 'Đã gỡ cách ly thẻ. Thẻ sẽ xuất hiện lại trong phiên ôn tập.');
    }
}
