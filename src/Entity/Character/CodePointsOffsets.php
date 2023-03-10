<?php
declare(strict_types=1);

namespace FDekker\Entity\Character;

class CodePointsOffsets
{
    /**
     * @param int[] $codePoints
     * @param int[] $offsets
     */
    public function __construct(public readonly array $codePoints, public readonly array $offsets)
    {
    }
}
