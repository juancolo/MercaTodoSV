<?php

namespace App\Entities;

use App\Constants\UserStatus;
use App\Constants\ProductStatus;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Concerns\HasAdministrationRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use Notifiable;
    use HasAdministrationRole;
    use HasApiTokens;

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
        'role'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'remember_token',
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
    public static function scopeUserInfo(Builder $query, ?string $userInfo = null): Builder
    {
        if (null !== $userInfo) {
            return $query->where('first_name', 'like', "%$userInfo%")
                ->orWhere('last_name', 'like', "%$userInfo%")
                ->orWhere('email', 'like', "%$userInfo%");
        }
        return $query;
    }

    public function scopeActiveUser(Builder $query)
    {
        return $query
            ->where('status', 'like',UserStatus::ACTIVE);
    }

    public function status(): string
    {
        return ProductStatus::STATUSES[$this->status];
    }
}
