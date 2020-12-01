<?php


namespace App\Constants;


interface UserStatus
{
    public const ACTIVE = 1;
    public const INACTIVE = 0;

    public const STATUSES = [
      self::ACTIVE => 'active',
      self::INACTIVE => 'inactive'
    ];
}
