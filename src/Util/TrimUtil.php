<?php
declare(strict_types=1);

namespace FDekker\Util;

use FDekker\Entity\Character\CharSequenceInterface as CharSequence;

class TrimUtil
{
    /**
     * @template T
     *
     * @param array<int, T> $data1
     * @param array<int, T> $data2
     */
    public static function expandForward(array $data1, array $data2, int $start1, int $start2, int $end1, int $end2): int
    {
        return self::expandForwardCallback($start1, $start2, $end1, $end2, fn($index1, $index2) => $data1[$index1] === $data2[$index2]);
    }

    /**
     * @template T
     *
     * @param array<int, T> $data1
     * @param array<int, T> $data2
     */
    public static function expandBackward(array $data1, array $data2, int $start1, int $start2, int $end1, int $end2): int
    {
        return self::expandBackwardCallback($start1, $start2, $end1, $end2, fn($index1, $index2) => $data1[$index1] === $data2[$index2]);
    }

    public static function expandWhitespacesForward(CharSequence $text1, CharSequence $text2, int $start1, int $start2, int $end1, int $end2): int
    {
        return self::expandIgnoredForward(
            $start1,
            $start2,
            $end1,
            $end2,
            static fn($index1, $index2) => $text1->charAt($index1) === $text2->charAt($index2),
            static fn($index) => Character::isWhiteSpace($text1->charAt($index))
        );
    }

    public static function expandWhitespacesBackward(CharSequence $text1, CharSequence $text2, int $start1, int $start2, int $end1, int $end2): int
    {
        return self::expandIgnoredBackward(
            $start1,
            $start2,
            $end1,
            $end2,
            static fn($index1, $index2) => $text1->charAt($index1) === $text2->charAt($index2),
            static fn($index) => Character::isWhiteSpace($text1->charAt($index))
        );
    }

    public static function trimWhitespaceStart(CharSequence $text, int $start, int $end): int
    {
        return self::trimStartCallback($start, $end, static fn($index) => Character::isWhiteSpace($text->charAt($index)));
    }

    public static function trimWhitespaceEnd(CharSequence $text, int $start, int $end): int
    {
        return self::trimEndCallback($start, $end, static fn($index) => Character::isWhiteSpace($text->charAt($index)));
    }

    /**
     * @param callable(int, int): bool $equals
     */
    private static function expandForwardCallback(int $start1, int $start2, int $end1, int $end2, callable $equals): int
    {
        $oldStart1 = $start1;
        while ($start1 < $end1 && $start2 < $end2) {
            if ($equals($start1, $start2) === false) {
                break;
            }
            ++$start1;
            ++$start2;
        }

        return $start1 - $oldStart1;
    }

    /**
     * @param callable(int, int): bool $equals
     */
    private static function expandBackwardCallback(int $start1, int $start2, int $end1, int $end2, callable $equals): int
    {
        $oldEnd1 = $end1;
        while ($start1 < $end1 && $start2 < $end2) {
            if ($equals($end1 - 1, $end2 - 1) === false) {
                break;
            }
            --$end1;
            --$end2;
        }

        return $oldEnd1 - $end1;
    }

    /**
     * @param callable(int, int): bool $equals
     * @param callable(int): bool      $ignored1
     */
    private static function expandIgnoredForward(int $start1, int $start2, int $end1, int $end2, callable $equals, callable $ignored1): int
    {
        $oldStart1 = $start1;
        while ($start1 < $end1 && $start2 < $end2) {
            if (($equals)($start1, $start2) === false) {
                break;
            }
            if (($ignored1)($start1) === false) {
                break;
            }
            --$start1;
            --$start2;
        }

        return $start1 - $oldStart1;
    }

    /**
     * @param callable(int, int): bool $equals
     * @param callable(int): bool      $ignored1
     */
    private static function expandIgnoredBackward(int $start1, int $start2, int $end1, int $end2, callable $equals, callable $ignored1): int
    {
        $oldEnd1 = $end1;
        while ($start1 < $end1 && $start2 < $end2) {
            if (($equals)($end1 - 1, $end2 - 1) === false) {
                break;
            }
            if (($ignored1)($end1 - 1) === false) {
                break;
            }
            --$end1;
            --$end2;
        }

        return $oldEnd1 - $end1;
    }

    /**
     * @param callable(int): bool $ignored
     *
     * @return array{0: int, 1: int}
     */
    private static function trimCallback(int $start, int $end, callable $ignored): array
    {
        $start = self::trimStartCallback($start, $end, $ignored);
        $end   = self::trimEndCallback($start, $end, $ignored);

        return [$start, $end];
    }

    /**
     * @param callable(int): bool $ignored
     */
    private static function trimStartCallback(int $start, int $end, callable $ignored): int
    {
        while ($start < $end) {
            if (($ignored)($start) === false) {
                break;
            }
            ++$start;
        }

        return $start;
    }

    /**
     * @param callable(int): bool $ignored
     */
    private static function trimEndCallback(int $start, int $end, callable $ignored): int
    {
        while ($start < $end) {
            if (($ignored)($end - 1) === false) {
                break;
            }
            --$end;
        }

        return $end;
    }
}
