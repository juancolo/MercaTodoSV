<?php


namespace App\Constants;


interface UserRoles
{
    public const ADMINISTRATOR = 'administrator';
    public const POWERUSER = 'power-user';
    public const CLIENT = 'client';

    public const ROLES = [
        self::ADMINISTRATOR,
        self::POWERUSER,
        self::CLIENT
    ];
}
