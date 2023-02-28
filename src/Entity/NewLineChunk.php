<?php
declare(strict_types=1);

namespace FDekker\Entity;

/**
 * @implements InlineChunk<NewLineChunk>
 */
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

    /**
     * @inheritdoc
     */
    public function equals(EquatableInterface $object): bool
    {
        return $object instanceof $this;
    }

    public function hashCode(): int
    {
        return spl_object_id($this);
    }
}
