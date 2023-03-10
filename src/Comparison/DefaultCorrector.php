<?php
declare(strict_types=1);

namespace FDekker\Comparison;

use FDekker\Diff\DiffIterableUtil;
use FDekker\Diff\Iterable\DiffIterableInterface;
use FDekker\Entity\Character\CharSequenceInterface;
use FDekker\Entity\Range;
use FDekker\Util\TrimUtil;

class DefaultCorrector
{
    /** @var Range[] */
    private array $changes = [];

    public function __construct(
        private readonly DiffIterableInterface $iterable,
        private readonly CharSequenceInterface $text1,
        private readonly CharSequenceInterface $text2
    ) {
    }

    public function build(): DiffIterableInterface
    {
        foreach ($this->iterable->changes() as $range) {
            $endCut   = TrimUtil::expandWhitespacesBackward(
                $this->text1,
                $this->text2,
                $range->start1,
                $range->start2,
                $range->end1,
                $range->end2
            );
            $startCut = TrimUtil::expandWhitespacesForward(
                $this->text1,
                $this->text2,
                $range->start1,
                $range->start2,
                $range->end1 - $endCut,
                $range->end2 - $endCut
            );

            $expand = new Range($range->start1 + $startCut, $range->end1 - $endCut, $range->start2 + $startCut, $range->end2 - $endCut);
            if ($expand->isEmpty() === false) {
                $this->changes[] = $expand;
            }
        }

        return DiffIterableUtil::createFromRanges($this->changes, $this->text1->length(), $this->text2->length());
    }
}
