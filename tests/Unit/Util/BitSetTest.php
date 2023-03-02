<?php
declare(strict_types=1);

namespace FDekker\Tests\Util;

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
        static::assertTrue($bitSet->get(126));
        static::assertFalse($bitSet->get(127));
    }

    public function testOutsideWordBoundary(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(2, 129);

        static::assertFalse($bitSet->get(1));
        static::assertTrue($bitSet->get(2));
        static::assertTrue($bitSet->get(64));
        static::assertTrue($bitSet->get(129));
        static::assertFalse($bitSet->get(130));
    }
}
