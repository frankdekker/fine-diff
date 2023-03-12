<?php
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

use DR\JBDiff\Entity\Range;
use Traversable;

/**
 * @implements CursorIteratorInterface<Range>
 */
class ChangedIterator implements CursorIteratorInterface
{
    public function __construct(private readonly ChangeIterableInterface $iterable)
    {
    }

    public function hasNext(): bool
    {
        return $this->iterable->valid();
    }

    public function next(): Range
    {
        $range = new Range($this->iterable->getStart1(), $this->iterable->getEnd1(), $this->iterable->getStart2(), $this->iterable->getEnd2());
        $this->iterable->next();

        return $range;
    }

    /**
     * @return Traversable<Range>
     */
    public function getIterator(): Traversable
    {
        while ($this->hasNext()) {
            yield $this->next();
        }
    }
}
