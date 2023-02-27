<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWord;
use FDekker\Entity\WordChunk;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ByWord::class)]
class ByWordTest extends TestCase
{
    public function testGetInlineChunksTwoWords(): void
    {
        $text     = "public int";
        $expected = [
            new WordChunk($text, 0, 6, 3317543529),
            new WordChunk($text, 7, 10, 104431),
        ];

        $chunks = ByWord::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }

    public function testGetInlineChunksSpecialCharacter(): void
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

    public function testGetInlineChunksNewLines(): void
    {
        $text     = "public int codë() {\ntest\n}\n";
        $expected = [
            new WordChunk($text, 0, 6, 3317543529),
            new WordChunk($text, 7, 10, 104431),
            new WordChunk($text, 11, 15, 3059315),
            new WordChunk($text, 20, 25, 105143808),
            new WordChunk($text, 26, 27, 110),
            new WordChunk($text, 29, 30, 110),
        ];

        $chunks = ByWord::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }
}
