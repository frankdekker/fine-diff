<?php
declare(strict_types=1);

namespace FDekker;

use FDekker\Entity\InlineChunk;
use FDekker\Enum\ComparisonPolicy;
use FDekker\Util\Character;
use IntlChar;

class ByWord
{
    public function compareAndSplit(string $text1, string $text2, ComparisonPolicy $comparisonPolicy)
    {
    }

    /**
     * @return InlineChunk[]
     */
    public static function getInlineChunks(string $text): array
    {
        $len    = mb_strlen($text);
        $offset = 0;

        $wordStart = -1;
        $wordHash  = 0;

        while ($offset < $len) {
            $ch        = IntlChar::ord(mb_substr($text, $offset, 1));
            $charCount = Character::charCount($ch);

            $isAlpha    = Character::isAlpha($ch);
            $isWordPart = $isAlpha && Character::isContinuousScript($ch);
        }
    }
}
