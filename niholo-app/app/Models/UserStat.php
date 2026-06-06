<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStat extends Model
{
    //

    protected $guarded = [];
    protected $casts = [
        'last_learned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addXp($amount)
    {
        $this->increment('total_xp', $amount);
        return $this;
    }

    public function incrementStreak()
    {
        $this->increment('current_streak');
        if ($this->current_streak > $this->longest_streak) {
            $this->longest_streak = $this->current_streak;
        }
        $this->last_learned_at = now();
        $this->save();
        return $this;
    }

    public function resetStreak()
    {
        if ($this->streak_freezes > 0) {
            $this->decrement('streak_freezes');
            $this->last_learned_at = now()->subDay(); // Prevent double trigger
        } else {
            $this->current_streak = 0;
        }
        $this->save();
        return $this;
    }
}
