<?php
declare(strict_types=1);

namespace FDekker\Util;

class Reindexer
{
    /** @var int[][] */
    private array $myOldIndices = [];

    /** @var array{0: int, 1: int} */
    private array $myOriginalLengths = [-1, 1];

    /** @var array{0: int, 1: int} */
    private array $myDiscardedLengths = [-1, 1];

    /**
     * @param int[] $ints1
     * @param int[] $ints2
     *
     * @return array{0: int[], 1: int[]}
     */
    public function discardUnique(array $ints1, array $ints2): array
    {
        $discarded = $this->discard($ints2, $ints1, 0);

        return [$discarded, $this->discard($discarded, $ints2, 1)];
    }

    /**
     * @param int[] $needed
     * @param int[] $toDiscard
     *
     * @return int[]
     */
    private function discard(array $needed, array $toDiscard, int $arrayIndex): array
    {
        $this->myOriginalLengths[$arrayIndex] = count($toDiscard);

        $sorted     = array_flip($needed);
        $discarded  = [];
        $oldIndices = [];

        foreach ($toDiscard as $i => $iValue) {
            if (isset($sorted[$iValue])) {
                $discarded[]  = $iValue;
                $oldIndices[] = $i;
            }
        }

        $this->myOldIndices[$arrayIndex]       = $oldIndices;
        $this->myDiscardedLengths[$arrayIndex] = count($discarded);

        return $discarded;
    }

    /**
     * @param int[] $indexes
     */
    private static function getOriginal(array $indexes, int $i): int
    {
        return $indexes[$i];
    }

    private static function increment(array $indexes, int $i, BitSet $set, int $length): int
    {
        if ($i + 1 < count($indexes)) {
            $set->set($indexes[$i] + 1, $indexes[$i + 1]);
        } else {
            $set->set($indexes[$i] + 1, $length);
        }

        return $i + 1;
    }
}
