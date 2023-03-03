<?php
declare(strict_types=1);

namespace FDekker;

use FDekker\Entity\InlineChunk;
use FDekker\Entity\NewLineChunk;
use FDekker\Entity\WordChunk;
use FDekker\Enum\ComparisonPolicy;
use FDekker\Util\Character;
use IntlChar;

class ByWord
{
    private const NEW_LINE = 10;

    public function compareAndSplit(string $text1, string $text2, ComparisonPolicy $comparisonPolicy)
    {
    }

    /**
     * @return InlineChunk[]
     */
    public static function getInlineChunks(string $text): array
    {
        $charSequence = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

        $wordStart = -1;
        $wordHash  = 0;
        $chunks    = [];

        foreach ($charSequence as $offset => $char) {
            $ch         = IntlChar::ord($char);
            $isAlpha    = Character::isAlpha($ch);
            $isWordPart = $isAlpha && Character::isContinuousScript($ch) === false;

            if ($isWordPart) {
                if ($wordStart === -1) {
                    $wordStart = $offset;
                    $wordHash  = 0;
                }
                $wordHash = $wordHash * 31 + $ch;
            } else {
                if ($wordStart !== -1) {
                    $chunks[]  = new WordChunk($text, $wordStart, $offset, $wordHash);
                    $wordStart = -1;
                }

                if ($isAlpha) { // continuous script
                    $chunks[] = new WordChunk($text, $offset, $offset + 1, $ch);
                } elseif ($ch === self::NEW_LINE) {
                    $chunks[] = new NewlineChunk($offset);
                }
            }
        }

        if ($wordStart !== -1) {
            $chunks[] = new WordChunk($text, $wordStart, count($charSequence), $wordHash);
        }

        return $chunks;
    }
}
