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
    public function testGetInlineChunks(): void
    {
        $text     = "public int hashCodë() {";
        $expected = [
            new WordChunk($text, 0, 6, -977423767),
            new WordChunk($text, 7, 10, 104431),
            new WordChunk($text, 11, 19, 147696801),
        ];

        $chunks = ByWord::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }
}
