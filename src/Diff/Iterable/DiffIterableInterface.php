<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use FDekker\Entity\Range;

interface DiffIterableInterface
{
    public function getLength1(): int;

    public function getLength2(): int;

    /**
     * @return CursorIteratorInterface<Range>
     */
    public function changes(): CursorIteratorInterface;

    /**
     * @return CursorIteratorInterface<Range>
     */
    public function unchanged(): CursorIteratorInterface;
}
