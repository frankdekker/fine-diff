<?php
declare(strict_types=1);

namespace DR\JBDiff\Tests\Unit\Util;

use DR\JBDiff\Entity\Character\CharSequence;
use DR\JBDiff\Util\Character;
use IntlChar;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[DataProvider('punctuationDataProvider')]
    public function testIsPunctuation(string $char, bool $expected): void
    {
        static::assertSame($expected, Character::isPunctuation(IntlChar::ord($char)));
    }

    public function testIsLeadingSpace(): void
    {
        static::assertFalse(Character::isLeadingSpace(CharSequence::fromString("a"), -1));
        static::assertFalse(Character::isLeadingSpace(CharSequence::fromString("a"), 0));
        static::assertFalse(Character::isLeadingSpace(CharSequence::fromString("a"), 1));

        static::assertTrue(Character::isLeadingSpace(CharSequence::fromString(" "), 0));
        static::assertTrue(Character::isLeadingSpace(CharSequence::fromString("a\n b"), 2));
        static::assertFalse(Character::isLeadingSpace(CharSequence::fromString("a b"), 1));
    }

    public function testIsTrailingSpace(): void
    {
        static::assertFalse(Character::isTrailingSpace(CharSequence::fromString("a"), -1));
        static::assertFalse(Character::isTrailingSpace(CharSequence::fromString("a"), 0));
        static::assertFalse(Character::isTrailingSpace(CharSequence::fromString("a"), 1));

        static::assertTrue(Character::isTrailingSpace(CharSequence::fromString(" "), 0));
        static::assertTrue(Character::isTrailingSpace(CharSequence::fromString("a \nb"), 1));
        static::assertFalse(Character::isTrailingSpace(CharSequence::fromString("a b"), 1));
    }

    public function testTest(): void {
        $test1 = IntlChar::ord("\n");
        $test2 = IntlChar::ord("\t");
        $test3 = IntlChar::ord(" ");
        $text4 = true;
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
