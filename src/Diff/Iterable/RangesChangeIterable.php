<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

use DR\JBDiff\Entity\Range;

class RangesChangeIterable implements ChangeIterableInterface
{
    private ?Range $last;
    private int    $current = 0;

    /**
     * @param Range[] $ranges
     */
    public function __construct(private readonly array $ranges)
    {
        $this->last = $this->ranges[$this->current] ?? null;
    }

    public function valid(): bool
    {
        return $this->last !== null;
    }

    public function next(): void
    {
        ++$this->current;
        $this->last = $this->ranges[$this->current] ?? null;
    }

    public function getStart1(): int
    {
        assert($this->last !== null);

        return $this->last->start1;
    }

    public function getStart2(): int
    {
        assert($this->last !== null);

        return $this->last->start2;
    }

    public function getEnd1(): int
    {
        assert($this->last !== null);

        return $this->last->end1;
    }

    public function getEnd2(): int
    {
        assert($this->last !== null);

        return $this->last->end2;
    }
}
