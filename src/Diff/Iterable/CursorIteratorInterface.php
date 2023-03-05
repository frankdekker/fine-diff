<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

/**
 * @template T
 */
interface CursorIteratorInterface
{
    public function hasNext(): bool;

    /**
     * @return T
     */
    public function next(): mixed;
}
