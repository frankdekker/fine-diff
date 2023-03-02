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

    public function set($bitIndex): void
    {
        $wordIdx = $bitIndex >> self::ADDRESS_BITS_PER_WORD;
        $bitIdx  = $bitIndex & self::WORD_MASK;

        if (isset($this->words[$wordIdx]) === false) {
            $this->words[$wordIdx] = 0;
        }
        $this->words[$wordIdx] |= (1 << $bitIdx);
    }

    public function get($bitIndex): bool
    {
        $wordIdx = $bitIndex >> self::ADDRESS_BITS_PER_WORD;
        $bitIdx  = $bitIndex & self::WORD_MASK;

        return (self::uRShift($this->words[$wordIdx] ?? 0, $bitIdx) & 1) !== 0;
    }

    private static function uRShift(int $value, int $shiftRight): int
    {
        return $shiftRight === 0 ? $value : ($value >> $shiftRight) & ~(1 << (8 * PHP_INT_SIZE - 1) >> ($shiftRight - 1));
    }
}
