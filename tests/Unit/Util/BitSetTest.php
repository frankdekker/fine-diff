<?php
declare(strict_types=1);

namespace FDekker\Tests\Util;

use AssertionError;
use FDekker\Util\BitSet;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BitSet::class)]
class BitSetTest extends TestCase
{
    public function testGetSetWithinWordBoundary(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(64, 126);

        static::assertFalse($bitSet->get(63));
        static::assertTrue($bitSet->get(64));
        static::assertTrue($bitSet->get(125));
        static::assertFalse($bitSet->get(126));
    }

    public function testOutsideWordBoundary(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(2, 129);

        static::assertFalse($bitSet->get(1));
        static::assertTrue($bitSet->get(2));
        static::assertTrue($bitSet->get(64));
        static::assertTrue($bitSet->get(128));
        static::assertFalse($bitSet->get(129));
    }

    public function testGetSetWithSingleArgument(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(64);

        static::assertFalse($bitSet->get(63));
        static::assertTrue($bitSet->get(64));
        static::assertFalse($bitSet->get(65));
    }

    public function testGetSetShouldSkipOnZeroRange(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(5, 5);
        static::assertFalse($bitSet->get(4));
        static::assertFalse($bitSet->get(5));
        static::assertFalse($bitSet->get(6));
    }

    public function testGetSetShouldDisallowNegativeStartIndex(): void
    {
        $bitSet = new BitSet();

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$fromIndex <= $toIndex');
        $bitSet->set(-1);
    }

    public function testGetSetShouldDisallowSecondArgumentBeforeFirst(): void
    {
        $bitSet = new BitSet();

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$fromIndex <= $toIndex');
        $bitSet->set(5, 4);
    }
}
