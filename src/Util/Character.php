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

    //fun isContinuousScript(c: Int): Boolean {
    //  if (c < 128) return false
    //  if (Character.isDigit(c)) return false
    //
    //  if (!Character.isBmpCodePoint(c)) return true
    //  if (Character.isIdeographic(c)) return true
    //  if (!Character.isAlphabetic(c)) return true
    //
    //  val script = Character.UnicodeScript.of(c)
    //  return script == Character.UnicodeScript.HIRAGANA ||
    //         script == Character.UnicodeScript.KATAKANA ||
    //         script == Character.UnicodeScript.THAI ||
    //         script == Character.UnicodeScript.JAVANESE
    //}

    public static function isContinuousScript(int $codePoint): bool
    {
        if ($codePoint < 128 || IntlChar::isdigit($codePoint)) {
            return false;
        }
        if (isset(Ideographic::CODEPOINTS[$codePoint]) || self::isBmpCodePoint($codePoint) === false || self::isAlphabetic($codePoint) === false) {
            return true;
        }

        // todo add support for
        // return script == Character.UnicodeScript.HIRAGANA ||
        //        script == Character.UnicodeScript.KATAKANA ||
        //        script == Character.UnicodeScript.THAI ||
        //        script == Character.UnicodeScript.JAVANESE

        return false;
    }

    public static function isAlphabetic(int $codePoint): bool
    {
        return match (IntlChar::charType($codePoint)) {
            IntlChar::CHAR_CATEGORY_UPPERCASE_LETTER,
            IntlChar::CHAR_CATEGORY_LOWERCASE_LETTER,
            IntlChar::CHAR_CATEGORY_TITLECASE_LETTER,
            IntlChar::CHAR_CATEGORY_MODIFIER_LETTER,
            IntlChar::CHAR_CATEGORY_OTHER_LETTER,
            IntlChar::CHAR_CATEGORY_LETTER_NUMBER => true,
            default                               => false,
        };
        // todo implement CharacterData.of(codePoint).isOtherAlphabetic(codePoint)
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

    public static function isBmpCodePoint(int $codePoint): bool
    {
        return self::unsignedRightShift($codePoint, 16) === 0;
    }

    /**
     * PHP implementation of $a >>> $b
     */
    private static function unsignedRightShift(int $a, float $b): int
    {
        if ($b >= 32 || $b < -32) {
            $m = (int)($b / 32);
            $b -= ($m * 32);
        }

        if ($b < 0) {
            $b = 32 + $b;
        }

        if ($b === 0) {
            return (($a >> 1) & 0x7fffffff) * 2 + (($a >> $b) & 1);
        }

        if ($a < 0) {
            $a >>= 1;
            $a &= 0x7fffffff;
            $a |= 0x40000000;
            $a >>= ($b - 1);
        } else {
            $a >>= $b;
        }

        return $a;
    }
}
