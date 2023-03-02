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

        for ($i = 0; $i < 1000000; $i++) {
            static::assertFalse($bitSet->get($i), '' . $i);

            $bitSet->set($i);
            static::assertTrue($bitSet->get($i), '' . $i);
            static::assertFalse($bitSet->get(32), 'Iteration: ' . $i);
        }
    }

    public function test32(): void
    {
        $bitSet = new BitSet();
        $bitSet->set(0);
        static::assertTrue($bitSet->get(0));
        static::assertFalse($bitSet->get(32));
    }
}
