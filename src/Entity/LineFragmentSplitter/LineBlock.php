<?php
declare(strict_types=1);

namespace FDekker\Entity\LineFragmentSplitter;

use FDekker\Entity\Range;

class LineBlock
{
    /**
     * @param DiffFragmentInterface[] $fragments
     */
    public function __construct(
        public readonly array $fragments,
        public readonly Range $offsets,
        public readonly int $newlines1,
        public readonly int $newlines2
    ) {
    }
}
