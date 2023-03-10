<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWord;
use FDekker\ChunkOptimizer\WordChunkOptimizer;
use FDekker\Diff\DiffIterableUtil;
use FDekker\Diff\DiffToBigException;
use FDekker\Diff\Iterable\SubiterableDiffIterable;
use FDekker\Diff\LineFragmentSplitter;
use FDekker\Entity\Character\CharSequence;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    /**
     * @throws DiffToBigException
     */
    public function testMain(): void
    {
        $text1 = CharSequence::fromString("public function int bar");
        $text2 = CharSequence::fromString("public foo int test");

        $words1 = ByWord::getInlineChunks($text1);
        $words2 = ByWord::getInlineChunks($text2);

        $wordChanges = DiffIterableUtil::diff($words1, $words2);
        $wordChanges = (new WordChunkOptimizer($words1, $words2, $text1, $text2, $wordChanges))->build();

        $wordBlocks = (new LineFragmentSplitter($text1, $text2, $words1, $words2, $wordChanges))->run();
        $lineBlocks = [];

        foreach ($wordBlocks as $block) {
            $offsets = $block->offsets;
            $words   = $block->words;

            $subText1 = $text1->subSequence($offsets->start1, $offsets->end1);
            $subText2 = $text2->subSequence($offsets->start2, $offsets->end2);

            $subWords1 = array_slice($words1, $words->start1, $words->end1 - $words->start1);
            $subWords2 = array_slice($words2, $words->start2, $words->end2 - $words->start2);

            $subiterable = DiffIterableUtil::fair(
                new SubiterableDiffIterable($wordChanges, $words->start1, $words->end1, $words->start2, $words->end2)
            );

            $delimitersIterable = DiffIterableUtil::matchAdjustmentDelimiters(
                $subText1,
                $subText2,
                $subWords1,
                $subWords2,
                $subiterable,
                $offsets->start1,
                $offsets->start2
            );
        }

        $test = true;
    }

}
