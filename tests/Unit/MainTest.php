<?php
declare(strict_types=1);

namespace DR\JBDiff\Tests\Unit;

use DR\JBDiff\ByWordRt;
use DR\JBDiff\Diff\DiffToBigException;
use DR\JBDiff\Diff\Iterable\FairDiffIterableWrapper;
use DR\JBDiff\Diff\Iterable\InvertedDiffIterableWrapper;
use DR\JBDiff\Diff\Iterable\RangesDiffIterable;
use DR\JBDiff\Entity\Character\CharSequence;
use DR\JBDiff\Entity\Range;
use DR\JBDiff\Enum\ComparisonPolicy;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    /**
     * @throws DiffToBigException
     */
    public function testMain(): void
    {
        $text1 = '    public function findBy(array $predicates, SortInterface $sort, ConnectionConfig|string $database, bool $convertToUtf8 = true): array
    {
        return $this->persistence->findBy($predicates, $sort, $database, $convertToUtf8);
';
        $text2 = '    public function findBy(array $predicates, SortInterface $sort, ConnectionConfig|string $database, string $encoding = \'utf8\'): array
    {
        if ($encoding !== \'latin1\' && $encoding !== \'utf8\') {
            throw new InvalidArgumentException(\'Expecting encoding to be `latin1` or `utf8`\');
        }

        return $this->persistence->findBy($predicates, $sort, $database, $encoding);
';

        $lineBlocks = ByWordRt::compareAndSplit(CharSequence::fromString($text1), CharSequence::fromString($text2), ComparisonPolicy::DEFAULT);

        $start  = 0;
        $result = [];
        foreach ($lineBlocks as $block) {
            $offset = $block->offsets;
            $subtext1 = mb_substr($text1, $offset->start1, $offset->end1 - $offset->start1);
            $subtext2 = mb_substr($text2, $offset->start2, $offset->end2 - $offset->start2);

            foreach ($block->fragments as $fragment) {
                $offsetStart = $start - $offset->start1;
                if ($offsetStart < $fragment->getStartOffset1()) {
                    $result[] = " " . mb_substr($subtext1, $offsetStart, $fragment->getStartOffset1() - $offsetStart);
                }

                if ($fragment->getStartOffset1() !== $fragment->getEndOffset1()) {
                    $result[] = "-" . mb_substr(
                            $subtext1,
                            $fragment->getStartOffset1(),
                            $fragment->getEndOffset1() - $fragment->getStartOffset1()
                        );
                }

                if ($fragment->getStartOffset2() !== $fragment->getEndOffset2()) {
                    $result[] = "+" . mb_substr(
                            $subtext2,
                            $fragment->getStartOffset2(),
                            $fragment->getEndOffset2() - $fragment->getStartOffset2()
                        );
                }

                $start = $offset->start1 + $fragment->getEndOffset1();
            }
        }

        if ($start < mb_strlen($text1)) {
            $result[] .= mb_substr($text1, $start);
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
