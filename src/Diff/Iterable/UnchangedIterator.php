<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use FDekker\Entity\Range;

/**
 * @implements CursorIteratorInterface<Range>
 */
class UnchangedIterator implements CursorIteratorInterface
{
    private int $lastIndex1 = 0;
    private int $lastIndex2 = 0;

    public function __construct(private readonly ChangeIterableInterface $iterable, private readonly int $length1, private readonly int $length2)
    {
        if ($this->iterable->valid() && $this->iterable->getStart1() === 0 && $this->iterable->getStart2() === 0) {
            $this->lastIndex1 = $this->iterable->getEnd1();
            $this->lastIndex1 = $this->iterable->getEnd2();
            $this->iterable->next();
        }
    }

    public function hasNext(): bool
    {
        return $this->iterable->valid() || ($this->lastIndex1 !== $this->length1 || $this->lastIndex2 !== $this->length2);
    }

    public function next(): Range
    {
        if ($this->iterable->valid()) {
            assert($this->iterable->getStart1() - $this->lastIndex1 !== 0 || $this->iterable->getStart2() - $this->lastIndex2 !== 0);
            $chunk = new Range($this->lastIndex1, $this->iterable->getStart1(), $this->lastIndex2, $this->iterable->getStart2());

            $this->lastIndex1 = $this->iterable->getEnd1();
            $this->lastIndex2 = $this->iterable->getEnd2();

            $this->iterable->next();

            return $chunk;
        }

        assert($this->length1 - $this->lastIndex1 !== 0 || $this->length2 - $this->lastIndex2 !== 0);
        $chunk = new Range($this->lastIndex1, $this->length1, $this->lastIndex2, $this->length2);

        $this->lastIndex1 = $this->length1;
        $this->lastIndex2 = $this->length2;

        return $chunk;
    }
}
