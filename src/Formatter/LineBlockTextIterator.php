<?php
declare(strict_types=1);

namespace DR\JBDiff\Formatter;

use DR\JBDiff\Entity\LineFragmentSplitter\LineBlock;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<array{0: self::TEXT_*, 1: string}>
 */
class LineBlockTextIterator implements IteratorAggregate
{
    public const TEXT_REMOVED   = -1;
    public const TEXT_UNCHANGED = 0;
    public const TEXT_ADDED     = 1;

    /**
     * @param LineBlock[] $blocks
     */
    public function __construct(private readonly string $text1, private readonly string $text2, private readonly array $blocks)
    {
    }

    /**
     * @return Traversable<array{0: self::TEXT_*, 1: string}>
     */
    public function getIterator(): Traversable
    {
        $start = 0;
        foreach ($this->blocks as $block) {
            $offset   = $block->offsets;
            $subtext1 = mb_substr($this->text1, $offset->start1, $offset->end1 - $offset->start1);
            $subtext2 = mb_substr($this->text2, $offset->start2, $offset->end2 - $offset->start2);

            foreach ($block->fragments as $fragment) {
                $offsetStart = $start - $offset->start1;
                if ($offsetStart < $fragment->getStartOffset1()) {
                    yield [self::TEXT_UNCHANGED, mb_substr($subtext1, $offsetStart, $fragment->getStartOffset1() - $offsetStart)];
                }

                if ($fragment->getStartOffset1() !== $fragment->getEndOffset1()) {
                    yield [
                        self::TEXT_REMOVED,
                        mb_substr(
                            $subtext1,
                            $fragment->getStartOffset1(),
                            $fragment->getEndOffset1() - $fragment->getStartOffset1()
                        )
                    ];
                }

                if ($fragment->getStartOffset2() !== $fragment->getEndOffset2()) {
                    yield [
                        self::TEXT_ADDED,
                        mb_substr(
                            $subtext2,
                            $fragment->getStartOffset2(),
                            $fragment->getEndOffset2() - $fragment->getStartOffset2()
                        )
                    ];
                }

                $start = $offset->start1 + $fragment->getEndOffset1();
            }

            if ($start < $block->offsets->end1) {
                yield [self::TEXT_UNCHANGED, mb_substr($this->text1, $start, $block->offsets->end1)];
                $start = $block->offsets->end1;
            }
        }

        if ($start < mb_strlen($this->text1)) {
            yield [self::TEXT_UNCHANGED, mb_substr($this->text1, $start)];
        }
    }
}
