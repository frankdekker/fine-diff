<?php
declare(strict_types=1);

namespace FDekker\Tests\Util;

use FDekker\Util\Character;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Character::class)]
class CharacterTest extends TestCase
{
    public function testIsContinuousScript(): void
    {
        // ascii character
        static::assertFalse(Character::isContinuousScript(127));

        // non continuous script
        static::assertFalse(Character::isContinuousScript(170));
        static::assertFalse(Character::isContinuousScript(181));

        // continuous script
        static::assertTrue(Character::isContinuousScript(65600));
    }
}
