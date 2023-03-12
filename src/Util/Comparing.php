<?php
declare(strict_types=1);

namespace DR\JBDiff\Util;

use DR\JBDiff\Entity\EquatableInterface;

class Comparing
{
    public static function equal(mixed $arg1, mixed $arg2): bool
    {
        if ($arg1 === $arg2) {
            return true;
        }
        if ($arg1 === null || $arg2 === null) {
            return false;
        }

        if (is_array($arg1) && is_array($arg2)) {
            // TODO implements Arrays.equals
            return false;
        }

        if ($arg1 instanceof EquatableInterface && $arg2 instanceof EquatableInterface) {
            return $arg1->equals($arg2);
        }

        return false;
    }
}
