<?php
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

use DR\JBDiff\Entity\Range;

class RangesDiffIterable extends AbstractChangeDiffIterable
{
    /**
     * @param Range[] $ranges
     */
    public function __construct(private readonly array $ranges, int $length1, int $length2)
    {
        parent::__construct($length1, $length2);
    }

    protected function createChangeIterable(): ChangeIterableInterface
    {
        return new RangesChangeIterable($this->ranges);
    }
}
