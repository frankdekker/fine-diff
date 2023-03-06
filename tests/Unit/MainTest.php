<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWord;
use FDekker\ChunkOptimizer\WordChunkOptimizer;
use FDekker\Diff\DiffIterableUtil;
use FDekker\Diff\DiffToBigException;
use FDekker\Diff\Iterable\SubiterableDiffIterable;
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

        $words1 = ByWord::getInlineChunks($text1);
        $words2 = ByWord::getInlineChunks($text2);

        $wordChanges = DiffIterableUtil::diff($words1, $words2);
        $wordChanges = (new WordChunkOptimizer($words1, $words2, $text1, $text2, $wordChanges))->build();

        $wordBlocks = (new LineFragmentSplitter($text1, $text2, $words1, $words2, $wordChanges))->run();
        $lineBlocks = [];

        foreach ($wordBlocks as $block) {
            $offsets = $block->offsets;
            $words   = $block->words;

            $subText1 = mb_substr($text1, $offsets->start1, $offsets->end1);
            $subText2 = mb_substr($text1, $offsets->start2, $offsets->end2);

            $subWords1 = array_slice($words1, $words->start1, $words->end1 - $words->start1);
            $subWords1 = array_slice($words2, $words->start2, $words->end2 - $words->start2);

            $subiterable = DiffIterableUtil::fair(
                new SubiterableDiffIterable($wordChanges, $words->start1, $words->end1, $words->start2, $words->end2)
            );
        }

        $test = true;
    }

}
