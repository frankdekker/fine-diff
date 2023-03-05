<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

class AbstractChangeDiffIterable implements DiffIterableInterface
{
    public function __construct(private readonly int $length1, private readonly int $length2)
    {
    }

    public function getLength1(): int
    {
        return $this->length1;
    }

    public function getLength2(): int
    {
        return $this->length2;
    }

    public function changes(): iterable
    {
    }

    public function unchanged(): iterable
    {
    }
}
