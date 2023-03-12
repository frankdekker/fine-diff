<?php
declare(strict_types=1);

namespace DR\JBDiff\Entity\LineFragmentSplitter;

use DR\JBDiff\Entity\Range;

class WordBlock
{
    public function __construct(public readonly Range $words, public readonly Range $offsets)
    {
    }
}
