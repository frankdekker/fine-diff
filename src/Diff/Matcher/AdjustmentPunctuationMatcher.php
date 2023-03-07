<?php
declare(strict_types=1);

namespace FDekker\Diff\Matcher;

use FDekker\Diff\Iterable\FairDiffIterableInterface;
use FDekker\Entity\InlineChunk;

class AdjustmentPunctuationMatcher
{
    private readonly int           $len1;
    private readonly int           $len2;
    private readonly ChangeBuilder $builder;

    /**
     * @param InlineChunk[] $words1
     * @param InlineChunk[] $words2
     */
    public function __construct(
        private readonly string $text1,
        private readonly string $text2,
        private readonly array $words1,
        private readonly array $words2,
        private readonly int $startShift1,
        private readonly int $startShift2,
        private readonly FairDiffIterableInterface $changes
    ) {
        $this->len1    = mb_strlen($this->text1);
        $this->len2    = mb_strlen($this->text2);
        $this->builder = new ChangeBuilder($this->len1, $this->len2);
    }

}
