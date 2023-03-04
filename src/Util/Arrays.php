<?php
declare(strict_types=1);

namespace FDekker\Util;

class Arrays
{
    /**
     * @param int[] $array array must be sorted
     */
    public static function binarySearch(array $array, int $fromIndex, int $toIndex, int $search): int
    {
        $low  = $fromIndex;
        $high = $toIndex - 1;

        while ($low <= $high) {
            $mid    = (int)floor(($low + $high) / 2);
            $midVal = $array[$mid] ?? 0;

            if ($midVal < $search) {
                $low = $mid + 1;
            } elseif ($midVal > $search) {
                $high = $mid - 1;
            } else {
                return $mid; // key found
            }
        }

        return -($low + 1);  // key not found.
    }
}
