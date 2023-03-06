<?php
declare(strict_types=1);

namespace FDekker\Entity\LineFragmentSplitter;

use FDekker\Entity\Range;

class WordBlock
{
    public function __construct(public readonly Range $words, public readonly Range $offsets)
    {
    }
}
