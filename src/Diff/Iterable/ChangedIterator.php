<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<Ran
 */
class ChangedIterator implements IteratorAggregate
{
    public function __construct(private readonly ChangeIterableInterface $iterable) {
    }

    public function getIterator(): Traversable
    {
    }
}
