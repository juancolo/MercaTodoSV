<?php

namespace App\Entities;

use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
*
*
* @
*/

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','email', 'password', 'active', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function category(): Relation
    {
        $this->hasOne(Category::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    /**
     * @param Builder $query
     * @param string|null $userInfo
     * @return Builder
     */
    public static function scopeUserInfo($query, ? string $userInfo)

    {
        if(null !== $userInfo){
            return $query   ->where('first_name', 'like', "%$userInfo%")
                ->orWhere('last_name', 'like', "%$userInfo%")
                ->orWhere('email', 'like', "%$userInfo%");
        }
        return $query;
    }
}
