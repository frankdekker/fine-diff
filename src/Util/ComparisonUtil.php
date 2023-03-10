<?php
declare(strict_types=1);

namespace FDekker\Util;

use FDekker\Entity\Character\CharSequenceInterface;
use FDekker\Enum\ComparisonPolicy;

class ComparisonUtil
{
    public static function isEquals(?CharSequenceInterface $text1, ?CharSequenceInterface $text2, ComparisonPolicy $policy): bool
    {
        if ($text1 === $text2) {
            return true;
        }
        if ($text1 === null || $text2 === null) {
            return false;
        }

        return match ($policy) {
            ComparisonPolicy::DEFAULT            =>
                mb_strtolower((string)$text1) === mb_strtolower((string)$text2),
            ComparisonPolicy::TRIM_WHITESPACES   =>
                mb_strtolower(trim((string)$text1)) === mb_strtolower(trim((string)$text2)),
            ComparisonPolicy::IGNORE_WHITESPACES =>
                mb_strtolower((string)preg_replace('/\s+/', '', (string)$text1)) === mb_strtolower((string)preg_replace('/\s+/', '', (string)$text2)),
        };
    }
}
