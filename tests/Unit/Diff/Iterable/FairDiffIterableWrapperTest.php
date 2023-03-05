<?php
declare(strict_types=1);

namespace FDekker\Tests\Diff\Iterable;

use FDekker\Diff\Iterable\DiffChangeChangeIterable;
use FDekker\Diff\Iterable\DiffChangeDiffIterable;
use FDekker\Diff\Iterable\DiffIterableInterface;
use FDekker\Diff\Iterable\FairDiffIterableWrapper;
use FDekker\Entity\Change;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\CoversClass;

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
