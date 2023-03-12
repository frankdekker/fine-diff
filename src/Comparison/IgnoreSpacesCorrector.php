<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Comparison;

use DR\JBDiff\Diff\DiffIterableUtil;
use DR\JBDiff\Diff\Iterable\DiffIterableInterface;
use DR\JBDiff\Entity\Character\CharSequenceInterface;
use DR\JBDiff\Entity\Range;
use DR\JBDiff\Util\TrimUtil;

class IgnoreSpacesCorrector
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
            $expanded = TrimUtil::expandWhitespaces($this->text1, $this->text2, $range);
            $trimmed = TrimUtil::trimWhitespacesRange($this->text1, $this->text2, $expanded);

            if ($trimmed->isEmpty() || TrimUtil::isEqualsIgnoreWhitespacesRange($this->text1, $this->text2, $trimmed)) {
                continue;
            }

            $this->changes[] = $trimmed;
        }

        return DiffIterableUtil::createFromRanges($this->changes, $this->text1->length(), $this->text2->length());
    }
}
