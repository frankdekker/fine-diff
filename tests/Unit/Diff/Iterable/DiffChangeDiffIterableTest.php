<?php
declare(strict_types=1);

namespace FDekker\Tests\Diff\Iterable;

use FDekker\Diff\Iterable\DiffChangeDiffIterable;
use FDekker\Entity\Change;
use FDekker\Entity\Range;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DiffChangeDiffIterable::class)]
class DiffChangeDiffIterableTest extends TestCase
{
    public function testIterator(): void
    {
        $change   = new Change(10, 20, 30, 40);
        $iterable = new DiffChangeDiffIterable($change, 50, 60);

        $changeIterator = $iterable->changes();
        static::assertTrue($changeIterator->hasNext());

        $range = $changeIterator->next();
        static::assertEquals(new Range(10, 40, 20, 60), $range);
    }
}
