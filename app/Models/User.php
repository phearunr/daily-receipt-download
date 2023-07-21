<?php

namespace App\Models;

use App\Traits\HasCan;
use App\Casts\UserRole;
use App\Models\OrderDrop;
use Ramsey\Uuid\Type\Integer;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    // use HasCan;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'status_id' => UserRole::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'status',
        'last_activity_at',
        // 'can',
        'role'
    ];

    public function getBasketCountAttribute()
    {
        return OrderDrop::query()
            ->where([
                'user_id' => auth()->id(),
                'status' => 0
            ])
            ->count();
    }

    public function getStatusAttribute()
    {
        return 'active';
    }
    public function getCreatedAtAttribute($value)
    {
        return now()->parse($value)->timezone(config('app.timezone'))->format('d F Y, H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return now()->parse($value)->timezone(config('app.timezone'))->diffForHumans();
    }


    public function getLastActivityAttribute()
    {
        return empty($this->last_login_at)
            ? NULL : date('d-M-Y H:i:s', $this->last_login_at['last_activity']);
    }

    public function getLastActivityAtAttribute()
    {
        return $this->belongsTo(
            LastLoginAt::class,
            'id',
            'user_id'
        );
    }

    // public function checkRole($role_id): bool
    // {
    //     return $this->role_id === $role_id;
    // }

    public function scopeMonth(Builder $builder, $date): object
    {
        if (!is_null($date)) {
            switch ($date) {
                case 'logged-in-today':
                    $builder->whereDate('last_activity', today());
                    break;
                case 'logged-in-last-7-days':
                    $builder->whereDate('last_activity', '>', today()->subDays(7));
                    break;
                case 'logged-in-last-30-days':
                    $builder->whereDate('last_activity', '>', today()->subDays(30));
                    break;
                case 'not-logged-in-for-30-days':
                    $builder->where('last_activity', '<', today()->subDays(30))
                        ->orWhere('last_activity', null);
                    break;
            }
        }
        return $builder;
    }

    public function scopeSearch(Builder $builder, $term): object
    {
        if (!is_null($term)) {
            $builder->where('name', 'like', '%' . $term . '%');
            $builder->orWhere('email', 'like', '%' . $term . '%');
        }
        return $builder;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (!$user->roles()->get()->contains(2)) {
                $user->roles()->attach(2);
            }
        });
    }

    public function getRoleAttribute()
    {
        return $this->roles()->pluck('title')[0];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
