<?php
declare(strict_types=1);

namespace DR\JBDiff\Tests\Unit\Diff\Iterable;

use DR\JBDiff\Diff\Iterable\DiffChangeDiffIterable;
use DR\JBDiff\Diff\Iterable\DiffIterableInterface;
use DR\JBDiff\Diff\Iterable\FairDiffIterableWrapper;
use DR\JBDiff\Entity\Change;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FairDiffIterableWrapper::class)]
class FairDiffIterableWrapperTest extends TestCase
{
    public function testChanges(): void
    {
        $iterable = $this->createMock(DiffIterableInterface::class);
        $wrapper  = new FairDiffIterableWrapper($iterable);

        $iterable->expects(self::once())->method('changes');

        $wrapper->changes();
    }

    public function testUnchanged(): void
    {
        $iterable = $this->createMock(DiffIterableInterface::class);
        $wrapper  = new FairDiffIterableWrapper($iterable);

        $iterable->expects(self::once())->method('unchanged');

        $wrapper->unchanged();
    }

    public function testGetLength(): void
    {
        $change  = new Change(10, 20, 30, 40);
        $wrapper = new FairDiffIterableWrapper(new DiffChangeDiffIterable($change, 50, 60));
        static::assertSame(50, $wrapper->getLength1());
        static::assertSame(60, $wrapper->getLength2());
    }
}
