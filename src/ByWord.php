<?php
declare(strict_types=1);

namespace FDekker;

use FDekker\Diff\FilesTooBigForDiffException;
use FDekker\Entity\Character\CharSequenceInterface;
use FDekker\Entity\InlineChunk;
use FDekker\Entity\NewLineChunk;
use FDekker\Entity\WordChunk;
use FDekker\Enum\ComparisonPolicy;
use FDekker\Util\Character;
use IntlChar;

class ByWord
{
    private const NEW_LINE = 10;

    /**
     * @throws FilesTooBigForDiffException
     */
    public function compareAndSplit(CharSequenceInterface $text1, CharSequenceInterface $text2, ComparisonPolicy $comparisonPolicy): void
    {
        // TODO finish all calls
        $inlineChunksA = self::getInlineChunks($text1);
        $inlineChunksB = self::getInlineChunks($text2);

        $changes = (new Diff())->buildChanges($inlineChunksA, $inlineChunksB);
        // wordChanges = optimizeWordChunks(text1, text2, words1, words2, wordChanges, indicator);

    }

    /**
     * @return InlineChunk[]
     */
    public static function getInlineChunks(CharSequenceInterface $text): array
    {
        $wordStart = -1;
        $wordHash  = 0;
        $chunks    = [];

        foreach ($text->chars() as $offset => $char) {
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
            $chunks[] = new WordChunk($text, $wordStart, $text->length(), $wordHash);
        }

        return $chunks;
    }
}
