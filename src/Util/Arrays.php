<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Util;

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
