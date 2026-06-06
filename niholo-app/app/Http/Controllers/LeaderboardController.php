<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
