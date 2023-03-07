<?php
declare(strict_types=1);

namespace FDekker\Entity\LineFragmentSplitter;

class PendingChunk
{
    public function __construct(
        public WordBlock $block,
        public bool $hasEqualsWords,
        public bool $hasWordsInside,
        public bool $isEqualIgnoreWhitespaces
    ) {
    }
}