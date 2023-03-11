<?php
declare(strict_types=1);

namespace FDekker\Entity\LineFragmentSplitter;

class DiffFragment implements DiffFragmentInterface
{
    public function __construct(
        private readonly int $startOffset1,
        private readonly int $endOffset1,
        private readonly int $startOffset2,
        private readonly int $endOffset2
    ) {
        assert($startOffset1 !== $endOffset1 || $startOffset2 !== $endOffset2);
        assert($startOffset1 <= $endOffset1 && $startOffset2 <= $endOffset2);
    }

    public function getStartOffset1(): int
    {
        return $this->startOffset1;
    }

    public function getEndOffset1(): int
    {
        return $this->endOffset1;
    }

    public function getStartOffset2(): int
    {
        return $this->startOffset2;
    }

    public function getEndOffset2(): int
    {
        return $this->endOffset2;
    }
}
