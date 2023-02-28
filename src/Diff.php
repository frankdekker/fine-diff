<?php
declare(strict_types=1);

namespace FDekker;

use FDekker\Entity\Change;
use FDekker\Entity\EquatableInterface;
use FDekker\Entity\NullChange;
use FDekker\Util\Enumerator;

class Diff
{
    /**
     * @param EquatableInterface[] $objects1
     * @param EquatableInterface[] $objects2
     */
    public function buildChanges(array $objects1, array $objects2): Change
    {
        $startShift = $this->getStartShift($objects1, $objects2);
        $endCut     = $this->getEndCut($objects1, $objects2, $startShift);

        //Ref<Change> changeRef = doBuildChangesFast(objects1.length, objects2.length, startShift, endCut);
        //    if (changeRef != null) return changeRef.get();

        $change = $this->doBuildChangesFast(count($objects1), count($objects2), $startShift, $endCut);
        if ($change !== null) {
            return $change;
        }

        $enumerator = new Enumerator();
        $ints1      = $enumerator->enumerate($objects1, $startShift, $endCut);
        $ints2      = $enumerator->enumerate($objects2, $startShift, $endCut);
    }

    /**
     * @param EquatableInterface[] $objects1
     * @param EquatableInterface[] $objects2
     */
    private function getStartShift(array $objects1, array $objects2): int
    {
        $size  = min(count($objects1), count($objects2));
        $index = 0;

        for ($i = 0; $i < $size; $i++) {
            if ($objects1[$i]->equals($objects2[$i]) === false) {
                break;
            }
            ++$index;
        }

        return $index;
    }

    /**
     * @param EquatableInterface[] $objects1
     * @param EquatableInterface[] $objects2
     */
    private function getEndCut(array $objects1, array $objects2, int $startShift): int
    {
        $length1 = count($objects1);
        $length2 = count($objects2);
        $size    = min($length1, $length2) - $startShift;
        $index   = 0;

        for ($i = 0; $i < $size; $i++) {
            if ($objects1[$length1 - $i - 1]->equals($objects2[$length2 - $i - 1]) === false) {
                break;
            }
            ++$index;
        }

        return $index;
    }

    /**
     * @return Change|null
     */
    private function doBuildChangesFast(int $length1, int $length2, int $startShift, int $endCut): ?Change
    {
        $trimmedLength1 = $length1 - $startShift - $endCut;
        $trimmedLength2 = $length2 - $startShift - $endCut;

        if ($trimmedLength1 !== 0 && $trimmedLength2 !== 0) {
            return null;
        }

        if ($trimmedLength1 === 0 && $trimmedLength2 === 0) {
            return new NullChange();
        }

        return new Change($startShift, $startShift, $trimmedLength1, $trimmedLength2);
    }
}