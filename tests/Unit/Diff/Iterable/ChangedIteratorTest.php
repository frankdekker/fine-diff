<?php
declare(strict_types=1);

namespace FDekker\Tests\Diff\Iterable;

use FDekker\Diff\Iterable\ChangedIterator;
use FDekker\Diff\Iterable\DiffChangeChangeIterable;
use FDekker\Entity\Change;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ChangedIterator::class)]
class ChangedIteratorTest extends TestCase
{
    public function testIteration(): void
    {
        $change = new Change(10, 20, 30, 40);

        $iterator = new ChangedIterator(new DiffChangeChangeIterable($change));
        static::assertTrue($iterator->hasNext());

        $range = $iterator->next();
        static::assertSame(10, $range->start1);
        static::assertSame(40, $range->end1);
        static::assertSame(20, $range->start2);
        static::assertSame(60, $range->end2);

        static::assertFalse($iterator->hasNext());
    }
}
