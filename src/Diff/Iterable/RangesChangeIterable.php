<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use FDekker\Entity\Range;

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
