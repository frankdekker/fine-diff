<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use FDekker\Entity\Range;

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
