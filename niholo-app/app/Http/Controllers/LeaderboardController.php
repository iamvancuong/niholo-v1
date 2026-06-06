<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Get the weekly leaderboard.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function weekly(Request $request): JsonResponse
    {
        $limit = $request->query('limit', 50);
        $leaderboard = $this->gamificationService->getWeeklyLeaderboard($limit);

        return response()->json([
            'leaderboard' => $leaderboard
        ]);
    }

    /**
     * Show the leaderboard page.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 50);
        $leaderboard = $this->gamificationService->getWeeklyLeaderboard($limit);

        // --- MOCK DATA FOR UI PREVIEW ---
        if (count($leaderboard) < 10) {
            $mockNames = ['Khánh Nguyễn Duy', 'Tâm Phạm Thùy Minh', 'Tài Tử', 'Nam Tran', 'Thuy Nguyen', 'Mỹ Duyên', 'Phan Trọng Nhân', 'Lan Chi', 'Hanh Nhu Luong'];
            $startRank = count($leaderboard) + 1;
            
            foreach ($mockNames as $index => $name) {
                if ($startRank > 50) break;
                $score = 25000 - ($startRank * 1000) + rand(-200, 200);
                $leaderboard[] = [
                    'rank' => $startRank,
                    'user_id' => 9990 + $index,
                    'name' => $name,
                    'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=fff&bold=true',
                    'is_premium' => rand(0, 1) == 1,
                    'score' => max(0, $score),
                    'streak' => rand(5, 80),
                    'total_cards' => rand(500, 3000),
                ];
                $startRank++;
            }
        }

        // Re-sort just in case
        usort($leaderboard, function($a, $b) {
            return $a['rank'] <=> $b['rank'];
        });
        // --------------------------------

        return Inertia::render('Leaderboard/Index', [
            'leaderboard' => $leaderboard
        ]);
    }
}
