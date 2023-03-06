<?php
declare(strict_types=1);

namespace FDekker\ChunkOptimizer;

use FDekker\Diff\Iterable\FairDiffIterableInterface;
use FDekker\Entity\InlineChunk;
use FDekker\Entity\NewLineChunk;
use FDekker\Entity\Range;
use FDekker\Entity\Side;
use FDekker\Util\Character;

/**
 * @extends AbstractChunkOptimizer<InlineChunk>
 */
class WordChunkOptimizer extends AbstractChunkOptimizer
{
    /**
     * @param InlineChunk[] $words1
     * @param InlineChunk[] $words2
     */
    public function __construct(
        array $words1,
        array $words2,
        private readonly string $text1,
        private readonly string $text2,
        FairDiffIterableInterface $changes
    ) {
        parent::__construct($words1, $words2, $changes);
    }

    protected function getShift(Side $touchSide, int $equalForward, int $equalBackward, Range $range1, Range $range2): int
    {
        $touchWords = $touchSide->select($this->data1, $this->data2);
        $touchText  = $touchSide->select($this->text1, $this->text2);
        $touchStart = $touchSide->select($range2->start1, $range2->start2);

        // check if chunks are already separated by whitespaces
        if (self::isSeparatedWithWhitespace($touchText, $touchWords[$touchStart - 1], $touchWords[$touchStart])) {
            return 0;
        }

        // shift chunks left [X]A Y[A ZA] -> [XA] YA [ZA]
        //                   [X][A ZA] -> [XA] [ZA]
        $leftShift = self::findSequenceEdgeShift($touchText, $touchWords, $touchStart, $equalForward, true);
        if ($leftShift > 0) {
            return $leftShift;
        }

        // shift chunks right [AX A]Y A[Z] -> [AX] AY [AZ]
        //                    [AX A][Z] -> [AX] [AZ]
        $rightShift = self::findSequenceEdgeShift($touchText, $touchWords, $touchStart - 1, $equalBackward, false);
        if ($rightShift > 0) {
            return -$rightShift;
        }

        // nothing to do
        return 0;
    }

    /**
     * @param InlineChunk[] $words
     */
    private static function findSequenceEdgeShift(string $text, array $words, int $offset, int $count, bool $leftToRight): int
    {
        for ($i = 0; $i < $count; $i++) {
            if ($leftToRight) {
                $word1 = $words[$offset + $i];
                $word2 = $words[$offset + $i + 1];
            } else {
                $word1 = $words[$offset - $i - 1];
                $word2 = $words[$offset - $i];
            }

            if (self::isSeparatedWithWhitespace($text, $word1, $word2)) {
                return $i + 1;
            }
        }

        return -1;
    }

    private static function isSeparatedWithWhitespace(string $text, InlineChunk $word1, InlineChunk $word2): bool
    {
        if ($word1 instanceof NewLineChunk || $word2 instanceof NewLineChunk) {
            return true;
        }

        $offset1 = $word1->getOffset2();
        $offset2 = $word2->getOffset1();

        // TODO check for performance improvement. See if mb_substr + preg_match is faster. Or store character sequence inside InlineChunk
        for ($i = $offset1; $i < $offset2; $i++) {
            if (Character::isWhiteSpace(mb_substr($text, $i, $i))) {
                return true;
            };
        }

        return false;
    }
}
