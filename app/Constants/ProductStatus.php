<?php


namespace App\Constants;

interface ProductStatus
{
    public const ACTIVE = 1;
    public const INACTIVE = 0;

    public const STATUSES = [
        self::ACTIVE => 'active',
        self::INACTIVE => 'inactive',
    ];
}
