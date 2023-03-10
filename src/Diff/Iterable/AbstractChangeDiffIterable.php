<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

abstract class AbstractChangeDiffIterable implements DiffIterableInterface
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

    /**
     * @inheritDoc
     */
    public function changes(): CursorIteratorInterface
    {
        return new ChangedIterator($this->createChangeIterable());
    }

    /**
     * @inheritDoc
     */
    public function unchanged(): CursorIteratorInterface
    {
        return new UnchangedIterator($this->createChangeIterable(), $this->length1, $this->length2);
    }

    abstract protected function createChangeIterable(): ChangeIterableInterface;
}
