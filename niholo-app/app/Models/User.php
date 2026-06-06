<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            // Tự động gán role 'guest' cho người dùng mới đăng ký
            if (!$user->hasAnyRole(['admin', 'pro', 'guest'])) {
                $user->assignRole('guest');
            }
            
            // Tự động tạo bản ghi UserStat
            $user->stat()->create();
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    public function userReviews()
    {
        return $this->hasMany(UserReview::class);
    }

    public function stat()
    {
        return $this->hasOne(UserStat::class);
    }

    public function learningSessions()
    {
        return $this->hasMany(LearningSession::class);
    }

    public function userQuests()
    {
        return $this->hasMany(UserQuest::class);
    }

    public function manualOverrides()
    {
        return $this->hasMany(ManualOverride::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
