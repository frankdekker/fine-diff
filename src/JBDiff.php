<?php
declare(strict_types=1);

namespace DR\JBDiff;

use DR\JBDiff\Diff\ByWordRt;
use DR\JBDiff\Diff\Util\DiffToBigException;
use DR\JBDiff\Entity\Character\CharSequence;
use DR\JBDiff\Entity\LineFragmentSplitter\LineBlock;

class JBDiff
{
    /**
     * @return LineBlock[]
     * @throws DiffToBigException
     */
    public static function compareAndSplit(
        CharSequence|string $text1,
        CharSequence|string $text2,
        ComparisonPolicy $policy = ComparisonPolicy::DEFAULT
    ): array {
        $text1 = is_string($text1) ? CharSequence::fromString($text1) : $text1;
        $text2 = is_string($text2) ? CharSequence::fromString($text2) : $text2;

        return ByWordRt::compareAndSplit($text1, $text2, $policy);
    }
}
