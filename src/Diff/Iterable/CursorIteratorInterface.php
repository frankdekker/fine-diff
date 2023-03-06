<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use IteratorAggregate;

/**
 * @template T
 * @extends IteratorAggregate<T>
 */
interface CursorIteratorInterface extends IteratorAggregate
{
    public function hasNext(): bool;

    /**
     * @return T
     */
    public function next(): mixed;
}
