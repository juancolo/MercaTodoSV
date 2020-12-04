<?php


namespace App\Concerns;


use App\Constants\UserRoles;

trait HasAdministrationRole
{
    public function hasAdminRole()
    {
        return $this->role === UserRoles::ADMINISTRATOR;
    }

    public function hasPowerrole()
    {
        return $this->role === UserRoles::POWERUSER;
    }
}
