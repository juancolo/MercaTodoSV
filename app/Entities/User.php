<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'active',
        'role'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return Relation
     */
    public function category(): Relation
    {
        $this->hasOne(Category::class);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @param Builder $query
     * @param string|null $userInfo
     * @return Builder
     */
    public static function scopeUserInfo($query, ?string $userInfo)

    {
        if (null !== $userInfo) {
            return $query->where('first_name', 'like', "%$userInfo%")
                ->orWhere('last_name', 'like', "%$userInfo%")
                ->orWhere('email', 'like', "%$userInfo%");
        }
        return $query;
    }
}
