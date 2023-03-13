<?php
// Copyright 2000-2021 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 Digital Revolution BV (123inkt.nl). Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Util;

use DR\JBDiff\Entity\Character\CharSequenceInterface;
use IntlChar;
use function count;
use function dirname;

class Character
{
    public const MIN_SUPPLEMENTARY_CODE_POINT = 0x010000;
    public const IS_WHITESPACE                = ["\n" => true, "\t" => true, " " => true];

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

        static $table;
        $table ??= require dirname(__DIR__, 2) . '/resources/NonContinuousScriptLookupTable.php';

        return $table[$codePoint] ?? true;
    }

    public static function isPunctuation(int $codePoint): bool
    {
        if ($codePoint === 95) { // exclude '_'
            return false;
        }

        // TODO replace with lookup table
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
        // TODO optimize function call. Replace calls with const
        return self::IS_WHITESPACE[$char] ?? false;
    }

    public static function isLeadingTrailingSpace(CharSequenceInterface $text, int $start): bool
    {
        return self::isLeadingSpace($text, $start) || self::isTrailingSpace($text, $start);
    }

    public static function isLeadingSpace(CharSequenceInterface $text, int $start): bool
    {
        $chars = $text->chars();
        if ($start < 0 || $start === count($chars) || self::isWhiteSpace($chars[$start]) === false) {
            return false;
        }

        --$start;
        while ($start >= 0) {
            $char = $chars[$start];
            if ($char === "\n") {
                return true;
            }
            if (self::isWhiteSpace($char) === false) {
                return false;
            }
            --$start;
        }

        return true;
    }

    public static function isTrailingSpace(CharSequenceInterface $text, int $end): bool
    {
        $chars = $text->chars();
        $len   = count($chars);
        if ($end < 0 || $end === $len || self::isWhiteSpace($chars[$end])) {
            return false;
        }

        while ($end < $len) {
            $char = $chars[$end];
            if ($char === "\n") {
                return true;
            }
            if (self::isWhiteSpace($char) === false) {
                return false;
            }
            ++$end;
        }

        return true;
    }
}
