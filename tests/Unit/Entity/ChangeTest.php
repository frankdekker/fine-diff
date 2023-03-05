<?php
declare(strict_types=1);

namespace FDekker\Tests\Entity;

use FDekker\Entity\Change;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Change::class)]
class ChangeTest extends TestCase
{
    public function testIsNull(): void
    {
        static::assertFalse((new Change(10, 20, 30, 40))->isNull());
    }

    public function testToArray(): void
    {
        $changeA       = new Change(10, 20, 30, 40);
        $changeB       = new Change(50, 60, 70, 80);
        $changeA->link = $changeB;

        static::assertSame([$changeA, $changeB], $changeA->toArray());
    }

    public function testToString(): void
    {
        $change = new Change(10, 20, 30, 40);
        static::assertSame('change[inserted=40, deleted=30, line0=10, line1=20]', (string)$change);
    }
}
