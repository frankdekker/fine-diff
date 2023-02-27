<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWord;
use FDekker\Entity\WordChunk;
use FDekker\Util\Ideographic;
use IntlChar;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ByWord::class)]
class ByWordTest extends TestCase
{
    public function testGetInlineChunksA(): void
    {
        $text     = "public int";
        $expected = [
            new WordChunk($text, 0, 6, 3317543529),
            new WordChunk($text, 7, 10, 104431),
        ];

        $chunks = ByWord::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }

    public function testGetInlineChunksB(): void
    {
        $text     = "public int codë() {";
        $expected = [
            new WordChunk($text, 0, 6, 3317543529),
            new WordChunk($text, 7, 10, 104431),
            new WordChunk($text, 11, 15, 3059315),
        ];

        $chunks = ByWord::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }
}
