<?php

namespace App\Policies;


use App\Entities\User;
use App\Entities\Order;
use App\Constants\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @return bool
     */
    public function before($user): bool
    {
        if ($user->hasRole(UserRoles::ADMINISTRATOR)) {
            return true;
        }
    }

    /**
     * @param User $user
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * @param User $user
     * @param Order $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    /**
     * @param User $user
     */
    public function create(User $user)
    {
        //
    }

    /**
     * @param User $user
     * @param Order $order
     */
    public function update(User $user, Order $order)
    {
        //
    }

    /**
     * @param User $user
     * @param Order $order
     */
    public function delete(User $user, Order $order)
    {
        //
    }


    /**
     * @param User $user
     * @param Order $order
     */
    public function restore(User $user, Order $order)
    {
        //
    }


    /**
     * @param User $user
     * @param Order $order
     */
    public function forceDelete(User $user, Order $order)
    {
        //
    }
}
