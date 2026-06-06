<?php

namespace App\Console\Commands;

use App\Models\UserStat;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStreaksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-streaks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset streaks for users who missed a day of learning';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting streak update process...');

        $now = Carbon::now();
        $startOfYesterday = $now->copy()->subDay()->startOfDay();

        // Find users whose streak is active (>0) but they haven't learned since before yesterday
        // So their last_learned_at is < startOfYesterday
        $userStats = UserStat::where('current_streak', '>', 0)
            ->where(function ($query) use ($startOfYesterday) {
                $query->where('last_learned_at', '<', $startOfYesterday)
                      ->orWhereNull('last_learned_at');
            })
            ->get();

        $count = 0;
        foreach ($userStats as $stat) {
            $stat->resetStreak();
            $count++;
        }

        $this->info("Updated streaks for {$count} users.");
    }
}
