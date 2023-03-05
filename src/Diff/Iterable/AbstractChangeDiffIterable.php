<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use FDekker\Entity\Range;

/**
 * Represents computed differences between two sequences.
 * <p>
 * All {@link Range} are not empty (have at least one element in one of the sides). Ranges do not overlap.
 * <p>
 * Differences are guaranteed to be 'squashed': there are no two changed or two unchanged {@link Range} with
 * <code>(range1.end1 == range2.start1 && range1.end2 == range2.start2)</code>.
 * @see FairDiffIterableInterface
 * @see DiffIterableUtil::iterateAll(DiffIterable)
 * @see DiffIterableUtil::verify(DiffIterable)
 */
abstract class AbstractChangeDiffIterable implements DiffIterableInterface
{
    public function __construct(private readonly int $length1, private readonly int $length2)
    {
    }

    /**
     * @return int length of the first sequence
     */
    public function getLength1(): int
    {
        return $this->length1;
    }

    /**
     * @return int length of the second sequence
     */
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

    protected abstract function createChangeIterable(): ChangeIterableInterface;
}
