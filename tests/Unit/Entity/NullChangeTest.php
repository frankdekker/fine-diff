<?php
declare(strict_types=1);

namespace FDekker\Tests\Entity;

use FDekker\Entity\NullChange;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(NullChange::class)]
class NullChangeTest extends TestCase
{
    public function testIsNull(): void
    {
        $change = new NullChange();
        static::assertTrue($change->isNull());
    }
}
