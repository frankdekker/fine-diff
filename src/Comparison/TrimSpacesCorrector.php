<?php
declare(strict_types=1);

namespace FDekker\Comparison;

use FDekker\Diff\DiffIterableUtil;
use FDekker\Diff\Iterable\DiffIterableInterface;
use FDekker\Entity\Character\CharSequenceInterface;
use FDekker\Entity\Range;
use FDekker\Enum\ComparisonPolicy;
use FDekker\Util\Character;
use FDekker\Util\ComparisonUtil;
use FDekker\Util\TrimUtil;

class TrimSpacesCorrector
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
            $start1 = $range->start1;
            $start2 = $range->start2;
            $end1   = $range->end1;
            $end2   = $range->end2;

            // TODO optimize this. Is the leading/trailing space really necessary. seems unnecessary iterating over the string
            if (Character::isLeadingTrailingSpace($this->text1, $start1)) {
                $start1 = TrimUtil::trimWhitespaceStart($this->text1, $start1, $end1);
            }
            if (Character::isLeadingTrailingSpace($this->text1, $end1 - 1)) {
                $end1 = TrimUtil::trimWhitespaceEnd($this->text1, $start1, $end1);
            }
            if (Character::isLeadingTrailingSpace($this->text2, $start2)) {
                $start2 = TrimUtil::trimWhitespaceStart($this->text2, $start2, $end2);
            }
            if (Character::isLeadingTrailingSpace($this->text2, $end2 - 1)) {
                $end2 = TrimUtil::trimWhitespaceEnd($this->text2, $start2, $end2);
            }

            $trimmed = new Range($start1, $end1, $start2, $end2);
            if ($trimmed->isEmpty()) {
                continue;
            }

            $sequence1 = $this->text1->subSequence($range->start1, $range->end1);
            $sequence2 = $this->text2->subSequence($range->start2, $range->end2);
            if (ComparisonUtil::isEquals($sequence1, $sequence2, ComparisonPolicy::DEFAULT)) {
                continue;
            }

            $this->changes[] = $trimmed;
        }

        return DiffIterableUtil::createFromRanges($this->changes, $this->text1->length(), $this->text2->length());
    }
}
