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
        $bitSet->setRange(64, 126);

        static::assertFalse($bitSet->get(63));
        static::assertTrue($bitSet->get(64));
        static::assertTrue($bitSet->get(126));
        static::assertFalse($bitSet->get(127));
    }

    public function test(): void
    {
        $bitSet = new BitSet();
        $bitSet->setRange(1, 62);

        static::assertFalse($bitSet->get(0));
        static::assertTrue($bitSet->get(1));
        static::assertTrue($bitSet->get(62));
        static::assertFalse($bitSet->get(63));
    }
}
