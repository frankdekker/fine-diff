<?php
declare(strict_types=1);

namespace FDekker\Util;

// TODO optimize for memory efficiency
class BitSet
{
    /** @var array<int, bool> */
    private array $index = [];

    public function set(int $fromIndex, int $toIndex): void
    {
        for ($i = $fromIndex; $i <= $toIndex; $i++) {
            $this->index[$i] = true;
        }
    }

    public function get(int $bit): bool
    {
        return $this->index[$bit] ?? false;
    }
}
