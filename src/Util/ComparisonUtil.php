<?php
declare(strict_types=1);

namespace FDekker\Util;

use FDekker\Enum\ComparisonPolicy;

class ComparisonUtil
{
    public static function isEquals(?string $text1, ?string $text2, ComparisonPolicy $policy): bool
    {
        if ($text1 === $text2) {
            return true;
        }
        if ($text1 === null || $text2 === null) {
            return false;
        }

        return match ($policy) {
            ComparisonPolicy::DEFAULT            =>
                mb_strtolower($text1) === mb_strtolower($text2),
            ComparisonPolicy::TRIM_WHITESPACES   =>
                mb_strtolower(trim($text1)) === mb_strtolower(trim($text2)),
            ComparisonPolicy::IGNORE_WHITESPACES =>
                mb_strtolower(preg_replace('/\s+/', '', $text1)) === mb_strtolower(preg_replace('/\s+/', '', $text2)),
        };
    }
}
