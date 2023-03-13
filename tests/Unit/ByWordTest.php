<?php
declare(strict_types=1);

namespace DR\JBDiff\Tests\Unit;

use DR\JBDiff\ByWordRt;
use DR\JBDiff\Entity\Character\CharSequence as CS;
use DR\JBDiff\Entity\Chunk\NewLineChunk;
use DR\JBDiff\Entity\Chunk\WordChunk;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ByWordRt::class)]
class ByWordTest extends TestCase
{
    public function testGetInlineChunksTwoWords(): void
    {
        $text     = CS::fromString("public int");
        $expected = [
            new WordChunk($text, 0, 6),
            new WordChunk($text, 7, 10),
        ];

        $chunks = ByWordRt::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }

    public function testGetInlineChunksSpecialCharacter(): void
    {
        $text     = CS::fromString("public int codë() {");
        $expected = [
            new WordChunk($text, 0, 6),
            new WordChunk($text, 7, 10),
            new WordChunk($text, 11, 15),
        ];

        $chunks = ByWordRt::getInlineChunks($text);
        static::assertEquals($expected, $chunks);

        /** @var WordChunk $chunk */
        $chunk = $chunks[2];
        static::assertSame("codë", $chunk->getContent());
    }

    public function testGetInlineChunksNewLinesA(): void
    {
        $text     = CS::fromString("public {\ntest");
        $expected = [
            new WordChunk($text, 0, 6),
            new NewLineChunk(8),
            new WordChunk($text, 9, 13),
        ];

        $chunks = ByWordRt::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }

    public function testGetInlineChunksNewLines(): void
    {
        $text     = CS::fromString("public int codë() {\ntest\n}\n");
        $expected = [
            new WordChunk($text, 0, 6),
            new WordChunk($text, 7, 10),
            new WordChunk($text, 11, 15),
            new NewLineChunk(19),
            new WordChunk($text, 20, 24),
            new NewLineChunk(24),
            new NewLineChunk(26),
        ];

        $chunks = ByWordRt::getInlineChunks($text);
        static::assertEquals($expected, $chunks);
    }
}
