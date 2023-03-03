<?php
declare(strict_types=1);

namespace FDekker\Util;

class BitSet
{
    /* set consts based on 32 or 64 bit architecture */
    private const ADDRESS_BITS_PER_WORD = PHP_INT_SIZE === 4 ? 5 : 6;
    private const WORD_MASK             = PHP_INT_SIZE === 4 ? 0x1f : 0x3f;
    private const MAX_WORD_SLOT         = PHP_INT_SIZE === 4 ? 32 : 64;
    private const MASK_ALL              = -1;

    /** @var array<int, int> */
    private array $words = [];

    public function set(int $fromIndex, int $toIndex): void
    {
        $startWordIdx = $fromIndex >> self::ADDRESS_BITS_PER_WORD;
        $endWordIdx   = $toIndex >> self::ADDRESS_BITS_PER_WORD;

        // calculate the bit mask from the starting index: 111111111100
        $startBitMask = $fromIndex === 0 ? self::MASK_ALL : ((1 << ($fromIndex & self::WORD_MASK)) - 1) ^ self::MASK_ALL;

        // calculate the bit mask till to end index: 001111111111
        $endBitIdx  = (1 << ($toIndex & self::WORD_MASK));
        $endBitMask = $toIndex === (self::MAX_WORD_SLOT - 1) ? self::MASK_ALL : $endBitIdx | ($endBitIdx - 1);

        // start and end within same word, combine mask and add to words
        if ($startWordIdx === $endWordIdx) {
            $this->words[$startWordIdx] ??= 0;
            $this->words[$startWordIdx] |= ($startBitMask & $endBitMask);

            return;
        }

        // loop over the word indices, add the start, all, or end masks to the list
        for ($wordIdx = $startWordIdx; $wordIdx <= $endWordIdx; $wordIdx++) {
            $this->words[$wordIdx] ??= 0;

            if ($wordIdx === $startWordIdx) {
                $this->words[$wordIdx] |= $startBitMask;
            } elseif ($wordIdx === $endWordIdx) {
                $this->words[$wordIdx] |= $endBitMask;
            } else {
                $this->words[$wordIdx] |= self::MASK_ALL;
            }
        }
    }

    public function get(int $bitIndex): bool
    {
        $wordIdx = $bitIndex >> self::ADDRESS_BITS_PER_WORD;
        $bitIdx  = $bitIndex & self::WORD_MASK;

        return (($this->words[$wordIdx] ?? 0) & (1 << $bitIdx)) !== 0;
    }

    public function clear(int $fromIndex, int $toIndex): void {
        // TODO
    }

    public function __toString(): string
    {
        $result = '';
        foreach ($this->words as $index => $bits) {
            $result .= $index . ': ' . str_pad(decbin($bits), self::MAX_WORD_SLOT, '0', STR_PAD_LEFT) . "\n";
        }

        return $result;
    }
}
