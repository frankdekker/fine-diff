<?php
declare(strict_types=1);

namespace FDekker;

use FDekker\Entity\InlineChunk;
use FDekker\Enum\ComparisonPolicy;

class ByWordRt
{
    public function compareAndSplit(string $text1, string $text2, ComparisonPolicy $comparisonPolicy)
    {
    }

    /**
     * @return InlineChunk[]
     */
    public static function getInlineChunks(string $text): array {

    }

}
