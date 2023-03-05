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

        static::assertFalse($bitSet->has(63));
        static::assertTrue($bitSet->has(64));
        static::assertTrue($bitSet->has(125));
        static::assertFalse($bitSet->has(126));
    }

    public function testOutsideWordBoundary(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(2, 129);

        static::assertFalse($bitSet->has(1));
        static::assertTrue($bitSet->has(2));
        static::assertTrue($bitSet->has(64));
        static::assertTrue($bitSet->has(128));
        static::assertFalse($bitSet->has(129));
    }

    public function testGetSetWithSingleArgumentOnEndingBoundary(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(63);

        static::assertFalse($bitSet->has(62));
        static::assertTrue($bitSet->has(63));
        static::assertFalse($bitSet->has(64));
    }

    public function testGetSetWithSingleArgumentOnStartingBoundary(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(64);

        static::assertFalse($bitSet->has(63));
        static::assertTrue($bitSet->has(64));
        static::assertFalse($bitSet->has(65));
    }

    public function testGetSetShouldSkipOnZeroRange(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(5, 5);
        static::assertFalse($bitSet->has(4));
        static::assertFalse($bitSet->has(5));
        static::assertFalse($bitSet->has(6));
    }

    public function testGetSetShouldDisallowNegativeStartIndex(): void
    {
        $bitSet = new BitSet();

        $this->expectException(AssertionError::class);
        $bitSet->set(-1);
    }

    public function testGetSetShouldDisallowSecondArgumentBeforeFirst(): void
    {
        $bitSet = new BitSet();

        $this->expectException(AssertionError::class);
        $bitSet->set(5, 4);
    }

    public function testClearSingleValue(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(63, 65);

        static::assertFalse($bitSet->has(62));
        static::assertTrue($bitSet->has(63));
        static::assertTrue($bitSet->has(64));

        $bitSet->clear(63);
        static::assertFalse($bitSet->has(62));
        static::assertFalse($bitSet->has(63));
        static::assertTrue($bitSet->has(64));
    }
}
