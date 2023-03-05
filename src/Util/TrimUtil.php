<?php
declare(strict_types=1);

namespace FDekker\Util;

class TrimUtil
{
    /**
     * @template T
     * @param array<int, T> $data1
     * @param array<int, T> $data2
     */
    public static function expandForward(array $data1, array $data2, int $start1, int $start2, int $end1, int $end2): int
    {
        return self::expandForwardCallback($start1, $start2, $end1, $end2, fn($index1, $index2) => $data1[$index1] === $data2[$index2]);
    }

    /**
     * @template T
     * @param array<int, T> $data1
     * @param array<int, T> $data2
     */
    public static function expandBackward(array $data1, array $data2, int $start1, int $start2, int $end1, int $end2): int
    {
        return self::expandBackwardCallback($start1, $start2, $end1, $end2, fn($index1, $index2) => $data1[$index1] === $data2[$index2]);
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
}
