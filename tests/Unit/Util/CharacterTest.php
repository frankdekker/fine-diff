<?php
declare(strict_types=1);

namespace DR\JBDiff\Tests\Unit\Util;

use DR\JBDiff\Util\Character;
use IntlChar;
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

    /**
     * @dataProvider punctuationDataProvider
     */
    public function testIsPunctuation(string $char, bool $expected): void
    {
        static::assertSame($expected, Character::isPunctuation(IntlChar::ord($char)));
    }

    /**
     * @return array<array<int|string>>
     */
    public static function punctuationDataProvider(): array
    {
        return [
            "0"  => ["0", false],
            "a"  => ["a", false],
            " "  => [" ", false],
            "!"  => ["!", true],
            "\"" => ["\"", true],
            "#"  => ["#", true],
            "$"  => ["$", true],
            "%"  => ["%", true],
            "&"  => ["&", true],
            "'"  => ["'", true],
            "("  => ["(", true],
            ")"  => [")", true],
            "*"  => ["*", true],
            "+"  => ["+", true],
            ","  => [",", true],
            "-"  => ["-", true],
            "."  => [".", true],
            "/"  => ["/", true],
            ":"  => [":", true],
            ";"  => [";", true],
            "<"  => ["<", true],
            "="  => ["=", true],
            ">"  => [">", true],
            "?"  => ["?", true],
            "@"  => ["@", true],
            "["  => ["[", true],
            "\\" => ["\\", true],
            "]"  => ["]", true],
            "^"  => ["^", true],
            "_"  => ["_", false],
            "`"  => ["`", true],
            "{"  => ["{", true],
            "|"  => ["|", true],
            "}"  => ["}", true],
            "~"  => ["~", true],
        ];
    }
}
