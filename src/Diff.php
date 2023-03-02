<?php
declare(strict_types=1);

namespace FDekker;

use FDekker\Entity\Change;
use FDekker\Entity\EquatableInterface;
use FDekker\Entity\NullChange;
use FDekker\Util\ChangeBuilder;
use FDekker\Util\Enumerator;
use FDekker\Util\Reindexer;

class Diff
{
    /**
     * @param EquatableInterface[] $objects1
     * @param EquatableInterface[] $objects2
     */
    public function buildChanges(array $objects1, array $objects2): ?Change
    {
        $startShift = $this->getStartShift($objects1, $objects2);
        $endCut     = $this->getEndCut($objects1, $objects2, $startShift);

        $change = $this->doBuildChangesFast(count($objects1), count($objects2), $startShift, $endCut);
        if ($change !== null) {
            return $change;
        }

        $enumerator = new Enumerator();
        $ints1      = $enumerator->enumerate($objects1, $startShift, $endCut);
        $ints2      = $enumerator->enumerate($objects2, $startShift, $endCut);

        return $this->doBuildChanges($ints1, $ints2, new ChangeBuilder($startShift));
    }

    private function doBuildChanges(array $ints1, array $ints2, ChangeBuilder $builder): ?Change
    {
        $reindexer = new Reindexer(); // discard unique elements, that have no chance to be matched
        $discarded = $reindexer->discardUnique($ints1, $ints2);

        if (count($discarded[0]) === 0 && count($discarded[1]) === 0) {
            // assert trimmedLength > 0
            $builder->addChange(count($ints1), count($ints2));

            return $builder->getFirstChange();
        }

        // TODO implement
        return new NullChange();
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
