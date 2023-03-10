<?php
declare(strict_types=1);

namespace FDekker;

use FDekker\Diff\DiffIterableUtil;
use FDekker\Diff\DiffToBigException;
use FDekker\Diff\Iterable\FairDiffIterableInterface;
use FDekker\Entity\Character\CharSequenceInterface as CharSequence;
use FDekker\Entity\Character\MergingCharSequence;
use FDekker\Entity\Couple;
use FDekker\Entity\Range;

class ByWordRt
{
    /**
     * Compare one char sequence with two others (as if they were single sequence)
     * Return two DiffIterable: (0, len1) - (0, len21) and (0, len1) - (0, len22)
     * @return Couple<FairDiffIterableInterface>
     * @throws DiffToBigException
     */
    public static function comparePunctuation2Side(CharSequence $text1, CharSequence $text21, CharSequence $text22): Couple
    {
        $text2   = new MergingCharSequence($text21, $text22);
        $changes = ByCharRt::comparePunctuation($text1, $text2);

        $ranges = self::splitIterable2Side($changes, $text21->length());

        $iterable1 = DiffIterableUtil::fair(DiffIterableUtil::createUnchanged($ranges->first, $text1->length(), $text21->length()));
        $iterable2 = DiffIterableUtil::fair(DiffIterableUtil::createUnchanged($ranges->second, $text1->length(), $text22->length()));

        return Couple::of($iterable1, $iterable2);
    }

    /**
     * @return Couple<Range[]>
     */
    private static function splitIterable2Side(FairDiffIterableInterface $changes, int $offset): Couple
    {
        $ranges1 = [];
        $ranges2 = [];

        foreach ($changes->unchanged() as $ch) {
            if ($ch->end2 <= $offset) {
                $ranges1[] = new Range($ch->start1, $ch->end1, $ch->start2, $ch->end2);
            } elseif ($ch->start2 >= $offset) {
                $ranges2[] = new Range($ch->start1, $ch->end1, $ch->start2 - $offset, $ch->end2 - $offset);
            } else {
                $len2 = $offset - $ch->start2;

                $ranges1[] = new Range($ch->start1, $ch->start1 + $len2, $ch->start2, $offset);
                $ranges2[] = new Range($ch->start1 + $len2, $ch->end1, 0, $ch->end2 - $offset);
            }
        }

        return Couple::of($ranges1, $ranges2);
    }
}