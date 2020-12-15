<?php


namespace App\Constants;


class Procedures
{
    public const ORDER_REPORTS_PROCEDURE = <<<'EOT'
CREATE PROCEDURE `reports_generate` (p_from date, p_until date)
BEGIN
    START TRANSACTION;
    DELETE FROM `reports` WHERE `date` BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY);
    INSERT INTO `reports` (`date`, `primary_id`, `status`, `total`)
    SELECT DATE(`created_at`) AS date, `user_id` as primary_id, `status`,
         COUNT(*) as total
         FROM orders
    WHERE `created_at` BETWEEN p_from AND DATE_ADD(p_until, INTERVAL 1 DAY)
    GROUP BY `date`, `primary_id`, `status`;
    COMMIT;
END
EOT;
}
