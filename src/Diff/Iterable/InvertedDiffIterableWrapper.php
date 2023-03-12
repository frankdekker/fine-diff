<?php
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

class InvertedDiffIterableWrapper implements DiffIterableInterface
{
    public function __construct(private readonly DiffIterableInterface $iterable)
    {
    }

    public function getLength1(): int
    {
        return $this->iterable->getLength1();
    }

    public function getLength2(): int
    {
        return $this->iterable->getLength2();
    }

    public function changes(): CursorIteratorInterface
    {
        return $this->iterable->unchanged();
    }

    public function unchanged(): CursorIteratorInterface
    {
        return $this->iterable->changes();
    }
}
