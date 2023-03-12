<?php
declare(strict_types=1);

namespace DR\JBDiff\Tests\Unit\Util;

use DR\JBDiff\Util\TrimUtil;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TrimUtil::class)]
class TrimUtilTest extends TestCase
{
    public function testExpandBackward(): void
    {
        // match [AB] from the start
        $data1 = ['a', 'b', 'c', 'd'];
        $data2 = ['d', 'a', 'b', 'f'];

        static::assertSame(2, TrimUtil::expandForward($data1, $data2, 0, 1, count($data1), count($data2) - 1));
    }

    public function testExpandForward(): void
    {
        // match [AB] from the end
        $data1 = ['d', 'c', 'b', 'a'];
        $data2 = ['f', 'b', 'a', 'd'];

        static::assertSame(2, TrimUtil::expandBackward($data1, $data2, 0, 0, count($data1), count($data2) - 1));
    }
}
