<?php
declare(strict_types=1);

namespace DR\JBDiff\Entity;

class NewLineChunk implements InlineChunk
{
    public function __construct(private int $offset)
    {
    }

    public function getOffset1(): int
    {
        return $this->offset;
    }

    public function getOffset2(): int
    {
        return $this->offset + 1;
    }

    public function equals(EquatableInterface $object): bool
    {
        return $object instanceof self;
    }
}
