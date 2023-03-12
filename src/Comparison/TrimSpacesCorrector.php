<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Comparison;

use DR\JBDiff\Diff\DiffIterableUtil;
use DR\JBDiff\Diff\Iterable\DiffIterableInterface;
use DR\JBDiff\Entity\Character\CharSequenceInterface;
use DR\JBDiff\Entity\Range;
use DR\JBDiff\Util\Character;
use DR\JBDiff\Util\Strings;
use DR\JBDiff\Util\TrimUtil;

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

            // TODO optimize this. Is the leading/trailing space really necessary. seems unnecessary iterating twice over the string
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
            if (Strings::equalsCaseSensitive($this->text1, $this->text2, $range->start1, $range->end1, $range->start2, $range->end2)) {
                continue;
            }

            $this->changes[] = $trimmed;
        }

        return DiffIterableUtil::createFromRanges($this->changes, $this->text1->length(), $this->text2->length());
    }
}
