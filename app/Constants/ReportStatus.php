<?php


namespace App\Constants;


use MyCLabs\Enum\Enum;

class ReportStatus extends Enum
{
public const PAI = 'pagada';
public const UNPAID = 'no pagada';
public const EXPIRED = 'vencida';

}
