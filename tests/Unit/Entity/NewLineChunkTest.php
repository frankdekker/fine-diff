<?php
declare(strict_types=1);

namespace FDekker\Tests\Entity;

use FDekker\Entity\NewLineChunk;
use FDekker\Entity\WordChunk;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(NewLineChunk::class)]
class NewLineChunkTest extends TestCase
{
    public function testHashCode(): void
    {
        $chunk = new NewLineChunk(5);
        static::assertGreaterThan(0, $chunk->hashCode());
    }

    public function testGetOffset1(): void
    {
        $chunk = new NewLineChunk(5);
        static::assertSame(5, $chunk->getOffset1());
    }

    public function testGetOffset2(): void
    {
        $chunk = new NewLineChunk(5);
        static::assertSame(5, $chunk->getOffset2());
    }

    public function testEquals(): void
    {
        $chunkA = new NewLineChunk(5);
        $chunkB = new NewLineChunk(6);
        $chunkC = new WordChunk('foobar', 1, 2, 3);

        static::assertTrue($chunkA->equals($chunkA));
        static::assertTrue($chunkA->equals($chunkB));
        static::assertFalse($chunkA->equals($chunkC));
    }
}
