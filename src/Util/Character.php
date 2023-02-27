<?php
declare(strict_types=1);

namespace FDekker\Util;

use IntlChar;

class Character
{
    public const MIN_SUPPLEMENTARY_CODE_POINT = 0x010000;

    public static function charCount(int $codePoint): int
    {
        return $codePoint >= self::MIN_SUPPLEMENTARY_CODE_POINT ? 2 : 1;
    }

    public static function isAlpha(int $codePoint): bool
    {
        return self::isWhiteSpaceCodePoint($codePoint) === false && self::isPunctuation($codePoint) === false;
    }

    public static function isContinuousScript(int $codePoint): bool
    {
        if ($codePoint < 128 || IntlChar::isdigit($codePoint)) {
            return false;
        }

        return NonContinuousScriptLookupTable::CODEPOINTS[$codePoint] ?? true;
    }

    public static function isPunctuation(int $codePoint): bool
    {
        if ($codePoint === 95) { // exclude '_'
            return false;
        }

        return ($codePoint >= 33 && $codePoint <= 47) || // !"#$%&'()*+,-./
            ($codePoint >= 58 && $codePoint <= 64) ||    // :;<=>?@
            ($codePoint >= 91 && $codePoint <= 96) ||    // [\]^_`
            ($codePoint >= 123 && $codePoint <= 126);    // {|}~
    }

    public static function isWhiteSpaceCodePoint(int $codePoint): bool
    {
        return $codePoint < 128 && self::isWhiteSpace(IntlChar::chr($codePoint));
    }

    public static function isWhiteSpace(string $char): bool
    {
        return $char === "\n" || $char === "\t" || $char === " ";
    }
}
