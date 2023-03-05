<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

class FairDiffIterableWrapper implements FairDiffIterableInterface
{
    public function __construct(private readonly DiffIterableInterface $iterable) {
    }

    public function getLength1(): int
    {
        return $this->iterable->getLength1();
    }

    public function getLength2(): int
    {
        return $this->iterable->getLength2();
    }

    /**
     * @inheritDoc
     */
    public function changes(): iterable
    {
        return $this->iterable->changes();
    }

    /**
     * @inheritDoc
     */
    public function unchanged(): iterable
    {
        return $this->iterable->unchanged();
    }
}
