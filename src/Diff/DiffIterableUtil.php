<?php
declare(strict_types=1);

namespace FDekker\Diff;

use FDekker\Diff;
use FDekker\Diff\Iterable\DiffChangeDiffIterable;
use FDekker\Diff\Iterable\DiffIterableInterface;
use FDekker\Diff\Iterable\FairDiffIterableInterface;
use FDekker\Diff\Iterable\FairDiffIterableWrapper;
use FDekker\Diff\Iterable\InvertedDiffIterableWrapper;
use FDekker\Diff\Iterable\RangesDiffIterable;
use FDekker\Diff\Matcher\AdjustmentPunctuationMatcher;
use FDekker\Entity\Change;
use FDekker\Entity\Character\CharSequenceInterface;
use FDekker\Entity\EquatableInterface;
use FDekker\Entity\InlineChunk;
use FDekker\Entity\Range;

class DiffIterableUtil
{
    /**
     * @param int[]|EquatableInterface[] $objects1
     * @param int[]|EquatableInterface[] $objects2
     *
     * @throws DiffToBigException
     */
    public static function diff(array $objects1, array $objects2): FairDiffIterableInterface
    {
        try {
            $change = (new Diff())->buildChanges($objects1, $objects2);

            return self::fair(self::create($change, count($objects1), count($objects2)));
        } catch (FilesTooBigForDiffException $e) {
            throw new DiffToBigException(previous: $e);
        }
    }

    public static function create(?Change $change, int $length1, int $length2): DiffIterableInterface
    {
        return new DiffChangeDiffIterable($change, $length1, $length2);
    }

    /**
     * @param Range[] $ranges
     */
    public static function createUnchanged(array $ranges, int $length1, int $length2): DiffIterableInterface
    {
        return new InvertedDiffIterableWrapper(new RangesDiffIterable($ranges, $length1, $length2));
    }

    public static function fair(DiffIterableInterface $iterable): FairDiffIterableInterface
    {
        if ($iterable instanceof FairDiffIterableInterface) {
            return $iterable;
        }

        return new FairDiffIterableWrapper($iterable);
    }

    /**
     * @param InlineChunk[] $words1
     * @param InlineChunk[] $words2
     *
     * @throws DiffToBigException
     */
    public static function matchAdjustmentDelimiters(
        CharSequenceInterface $text1,
        CharSequenceInterface $text2,
        array $words1,
        array $words2,
        FairDiffIterableInterface $changes,
        int $startShift1,
        int $startShift2
    ): FairDiffIterableInterface {
        return (new AdjustmentPunctuationMatcher($text1, $text2, $words1, $words2, $startShift1, $startShift2, $changes))->build();
    }
}
