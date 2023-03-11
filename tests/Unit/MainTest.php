<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWordRt;
use FDekker\Diff\DiffToBigException;
use FDekker\Diff\Iterable\FairDiffIterableWrapper;
use FDekker\Diff\Iterable\InvertedDiffIterableWrapper;
use FDekker\Diff\Iterable\RangesDiffIterable;
use FDekker\Entity\Character\CharSequence;
use FDekker\Entity\Range;
use FDekker\Enum\ComparisonPolicy;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    /**
     * @throws DiffToBigException
     */
    public function testMain(): void
    {
        $text1 = "/** this is a comment that was removed */\npublic function int bar() {";
        $text2 = "public foo int test() {";

        $lineBlocks = ByWordRt::compareAndSplit(CharSequence::fromString($text1), CharSequence::fromString($text2), ComparisonPolicy::DEFAULT);

        $start  = 0;
        $result = "";
        foreach ($lineBlocks as $block) {
            foreach ($block->fragments as $fragment) {
                if ($start < $fragment->getStartOffset1()) {
                    $result .= mb_substr($text1, $start, $fragment->getStartOffset1() - $start);
                }

                if ($fragment->getStartOffset1() !== $fragment->getEndOffset1()) {
                    $result .= "-`" . mb_substr(
                            $text1,
                            $fragment->getStartOffset1(),
                            $fragment->getEndOffset1() - $fragment->getStartOffset1()
                        ) . "`";
                }

                if ($fragment->getStartOffset2() !== $fragment->getEndOffset2()) {
                    $result .= "+`" . mb_substr(
                            $text2,
                            $fragment->getStartOffset2(),
                            $fragment->getEndOffset2() - $fragment->getStartOffset2()
                        ) . "`";
                }

                $start = $fragment->getEndOffset1();
            }
        }

        if ($start < mb_strlen($text1)) {
            $result .= mb_substr($text1, $start);
        }

        $test = true;
    }

    public function testSubIterable(): void
    {
        $range1           = new Range(8, 9, 0, 1);
        $range2           = new Range(10, 11, 2, 3);
        $rangeIterable    = new RangesDiffIterable([$range1, $range2], 12, 4);
        $invertedIterable = new InvertedDiffIterableWrapper($rangeIterable);
        $iterable         = new FairDiffIterableWrapper($invertedIterable);


    }
}
