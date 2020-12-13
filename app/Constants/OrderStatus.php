<?php


namespace App\Constants;


interface OrderStatus
{
    public const OK = 'ok';
    public const PENDING = 'pending';
    public const FAILED = 'failed';
    public const APPROVED = 'approved';
    public const APPROVED_PARTIAL = 'approved_partial';
    public const REJECTED = 'rejected';
    public const PARTIAL_EXPIRED = 'partial_expired';
    public const PENDING_VALIDATION = 'pending_validation';
    public const REFUNDED = 'refunded';

    public const STATUSES = [
        self::OK,
        self::PENDING,
        self::FAILED,
        self::APPROVED,
        self::APPROVED_PARTIAL,
        self::REJECTED,
        self::REFUNDED,
        self::PARTIAL_EXPIRED,
        self::PENDING_VALIDATION
    ];
}
