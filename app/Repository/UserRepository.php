<?php


namespace App\Repository;


use App\Entities\User;

class UserRepository extends BaseRepositories
{
    public function getModel()
    {
        return new User();
    }
}
