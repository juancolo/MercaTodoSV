<?php

namespace App\Policies;


use App\Entities\Order;
use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;


    /**
     * @param User $user
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->id;
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
