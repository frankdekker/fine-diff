<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use FDekker\Entity\Change;

class DiffChangeChangeIterable implements ChangeIterableInterface
{
    public function __construct(private ?Change $change)
    {
    }

    public function valid(): bool
    {
        return $this->change !== null;
    }

    public function next(): void
    {
        $this->change = $this->change->link;
    }

    public function getStart1(): int
    {
        return $this->change->line0;
    }

    public function getStart2(): int
    {
        return $this->change->line1;
    }

    public function getEnd1(): int
    {
        return $this->change->line0 + $this->change->deleted;
    }

    public function getEnd2(): int
    {
        return $this->change->line1 + $this->change->inserted;
    }
}
