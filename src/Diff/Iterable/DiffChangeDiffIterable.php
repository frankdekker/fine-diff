<?php
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

use DR\JBDiff\Entity\Change;

class DiffChangeDiffIterable extends AbstractChangeDiffIterable
{
    public function __construct(private readonly ?Change $change, int $length1, int $length2)
    {
        parent::__construct($length1, $length2);
    }

    protected function createChangeIterable(): ChangeIterableInterface
    {
        return new DiffChangeChangeIterable($this->change);
    }
}
