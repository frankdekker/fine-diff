<?php
declare(strict_types=1);

namespace FDekker\Tests\Util;

use FDekker\Util\BitSet;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BitSet::class)]
class BitSetTest extends TestCase
{
    public function testAccessors(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(5, 1000000 - 1);

        static::assertFalse($bitSet->get(4));
        static::assertTrue($bitSet->get(5));
        static::assertTrue($bitSet->get(999999));
        static::assertFalse($bitSet->get(1000000));
    }
}
