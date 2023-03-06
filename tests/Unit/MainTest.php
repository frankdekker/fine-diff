<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWord;
use FDekker\ChunkOptimizer\WordChunkOptimizer;
use FDekker\Diff\DiffIterableUtil;
use FDekker\Diff\DiffToBigException;
use FDekker\Diff\LineFragmentSplitter;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    /**
     * @throws DiffToBigException
     */
    public function testMain(): void
    {
        $text1 = "public function int bar";
        $text2 = "public foo int test";

        $inlineChunksA = ByWord::getInlineChunks($text1);
        $inlineChunksB = ByWord::getInlineChunks($text2);

        $wordChanges = DiffIterableUtil::diff($inlineChunksA, $inlineChunksB);
        $wordChanges = (new WordChunkOptimizer($inlineChunksA, $inlineChunksB, $text1, $text2, $wordChanges))->build();

        $wordBlocks = (new LineFragmentSplitter($text1, $text2, $inlineChunksA, $inlineChunksB, $wordChanges))->run();

        $test = true;
    }

}
