<?php
// Copyright 2000-2021 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 Digital Revolution BV (123inkt.nl). Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Util;

use Stringable;

class BitSet implements Stringable
{
    /* set consts based on 32 or 64 bit architecture */
    private const ADDRESS_BITS_PER_WORD = PHP_INT_SIZE === 4 ? 5 : 6;
    private const WORD_MASK             = PHP_INT_SIZE === 4 ? 0x1f : 0x3f;
    private const MAX_WORD_SLOT         = PHP_INT_SIZE === 4 ? 32 : 64;
    private const MASK_ALL              = -1;

    /** @var array<int, int> */
    private array $words = [];

    /**
     * Sets the bits from the specified $fromIndex (inclusive) to the
     * specified `toIndex` (exclusive) to `true`.
     *
     * @param int  $fromIndex index of the first bit to be set
     * @param ?int $toIndex   index after the last bit to be set
     */
    public function set(int $fromIndex, ?int $toIndex = null): void
    {
        foreach ($this->getWords($fromIndex, $toIndex) as $wordIdx => $value) {
            $this->words[$wordIdx] ??= 0;
            $this->words[$wordIdx] |= $value;
        }
    }

    public function clear(int $fromIndex, ?int $toIndex = null): void
    {
        foreach ($this->getWords($fromIndex, $toIndex) as $wordIdx => $value) {
            if (isset($this->words[$wordIdx]) === false) {
                continue;
            }

            $this->words[$wordIdx] &= self::MASK_ALL ^ $value;
            if ($this->words[$wordIdx] === 0) {
                unset($this->words[$wordIdx]);
            }
        }
    }

    public function has(int $bitIndex): bool
    {
        $wordIdx = $bitIndex >> self::ADDRESS_BITS_PER_WORD;
        $bitIdx  = $bitIndex & self::WORD_MASK;

        return (($this->words[$wordIdx] ?? 0) & (1 << $bitIdx)) !== 0;
    }

    public function __toString(): string
    {
        $result = '';
        foreach ($this->words as $index => $bits) {
            $result .= $index . ': ' . str_pad(decbin($bits), self::MAX_WORD_SLOT, '0', STR_PAD_LEFT) . "\n";
        }

        return $result;
    }

    /**
     * @return array<int, int>
     */
    private function getWords(int $fromIndex, ?int $toIndex = null): array
    {
        if ($fromIndex === $toIndex) {
            return [];
        }

        $toIndex = $toIndex === null ? $fromIndex : $toIndex - 1;
        assert($fromIndex >= 0 && $fromIndex <= $toIndex);

        $startWordIdx = $fromIndex >> self::ADDRESS_BITS_PER_WORD;
        $endWordIdx   = $toIndex >> self::ADDRESS_BITS_PER_WORD;

        // calculate the bit mask from the starting index: 111111111100
        $startBitMask = -1 << ($fromIndex % self::MAX_WORD_SLOT);

        // calculate the bit mask till to end index: 001111111111
        $endBitMask = (-1 << (($toIndex % self::MAX_WORD_SLOT) + 1)) ^ -1;

        $words = [];

        // start and end within same word, combine mask and add to words
        if ($startWordIdx === $endWordIdx) {
            $words[$startWordIdx] = ($startBitMask & $endBitMask);

            return $words;
        }

        // loop over the word indices, add the start, all, or end masks to the list
        for ($wordIdx = $startWordIdx; $wordIdx <= $endWordIdx; $wordIdx++) {
            if ($wordIdx === $startWordIdx) {
                $words[$wordIdx] = $startBitMask;
            } elseif ($wordIdx === $endWordIdx) {
                $words[$wordIdx] = $endBitMask;
            } else {
                $words[$wordIdx] = self::MASK_ALL;
            }
        }

        return $words;
    }
}
