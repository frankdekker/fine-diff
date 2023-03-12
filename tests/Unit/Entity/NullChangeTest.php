<?php
declare(strict_types=1);

namespace DR\JBDiff\Tests\Unit\Entity;

use DR\JBDiff\Entity\NullChange;
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
