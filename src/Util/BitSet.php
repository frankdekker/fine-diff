<?php
declare(strict_types=1);

namespace FDekker\Util;

class BitSet
{
    /* set word size based on 32 or 64 bit architecture */
    private const ADDRESS_BITS_PER_WORD = PHP_INT_MAX === 4 ? 5 : 6;
    private const WORD_MASK             = PHP_INT_MAX === 4 ? 0x1f : 0x3f;

    /** @var array<int, int> */
    private array $words = [];

    public function set(int $fromIndex, int $toIndex): void
    {
        for ($i = $fromIndex; $i <= $toIndex; $i++) {
            $wordIdx = $i >> self::ADDRESS_BITS_PER_WORD;
            $bitIdx  = $i & self::WORD_MASK;

            $this->words[$wordIdx] = ($this->words[$wordIdx] ?? 0) | (1 << $bitIdx);
        }
    }

    public function get(int $bitIndex): bool
    {
        $wordIdx = $bitIndex >> self::ADDRESS_BITS_PER_WORD;
        $bitIdx  = $bitIndex & self::WORD_MASK;

        return (self::unsignedRightShift($this->words[$wordIdx] ?? 0, $bitIdx) & 1) !== 0;
    }

    private static function unsignedRightShift(int $value, int $shiftRight): int
    {
        return $shiftRight === 0 ? $value : ($value >> $shiftRight) & ~(1 << (8 * PHP_INT_SIZE - 1) >> ($shiftRight - 1));
    }
}
