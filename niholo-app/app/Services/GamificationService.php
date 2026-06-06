<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserStat;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class GamificationService
{
    /**
     * Award XP to a user and update their streak.
     *
     * @param User $user
     * @param int $xpAmount
     * @return UserStat
     */
    public function awardXp(User $user, int $xpAmount): UserStat
    {
        $stat = $user->stat;
        
        if (!$stat) {
            $stat = $user->stat()->create();
        }

        // Add XP
        $stat->addXp($xpAmount);

        // Update Streak Logic
        $this->updateStreak($stat);

        // Update Redis Leaderboard
        $this->updateLeaderboard($user, $xpAmount);

        return $stat;
    }

    /**
     * Update the user's streak based on their last learned time.
     */
    protected function updateStreak(UserStat $stat): void
    {
        $now = Carbon::now();
        $lastLearned = $stat->last_learned_at;

        if (!$lastLearned) {
            // First time learning
            $stat->incrementStreak();
        } else {
            $daysDifference = $now->copy()->startOfDay()->diffInDays($lastLearned->copy()->startOfDay());

            if ($daysDifference == 1) {
                // Learned yesterday, increment streak
                $stat->incrementStreak();
            } elseif ($daysDifference > 1) {
                // Missed more than 1 day, try to use streak freeze or reset
                $stat->resetStreak();
                // Then increment for today
                $stat->incrementStreak();
            } else {
                // Already learned today, just update the timestamp
                $stat->last_learned_at = $now;
                $stat->save();
            }
        }
    }

    /**
     * Update the Redis leaderboard with the new XP.
     */
    protected function updateLeaderboard(User $user, int $xpAmount): void
    {
        try {
            // Weekly Leaderboard Key
            $yearWeek = Carbon::now()->format('Y_W');
            $leaderboardKey = "leaderboard:weekly:{$yearWeek}";

            // Increment user's score in the sorted set
            Redis::zincrby($leaderboardKey, $xpAmount, $user->id);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Redis Leaderboard Error: " . $e->getMessage());
        }
    }

    /**
     * Get the top users for the current week.
     */
    public function getWeeklyLeaderboard(int $limit = 50): array
    {
        try {
            $yearWeek = Carbon::now()->format('Y_W');
            $leaderboardKey = "leaderboard:weekly:{$yearWeek}";

            // Get top users (scores in descending order)
            $topUsers = Redis::zrevrange($leaderboardKey, 0, $limit - 1, 'WITHSCORES');

            if (empty($topUsers)) {
                return [];
            }

            $userIds = array_keys($topUsers);
            
            // Fetch user models to get names and avatars
            $users = User::whereIn('id', $userIds)->get()->keyBy('id');

            $leaderboard = [];
            $rank = 1;

            foreach ($topUsers as $userId => $score) {
                if (isset($users[$userId])) {
                    $leaderboard[] = [
                        'rank' => $rank++,
                        'user_id' => $userId,
                        'name' => $users[$userId]->name,
                        'score' => (int) $score,
                    ];
                }
            }

            return $leaderboard;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Redis Leaderboard Read Error: " . $e->getMessage());
            return [];
        }
    }
}
