<?php
declare(strict_types=1);

namespace FDekker\Entity;

/**
 * @implements InlineChunk<WordChunk>
 */
class WordChunk implements InlineChunk
{
    public function __construct(private string $text, private int $offset1, private int $offset2, private int $hash)
    {
    }

    public function getContent(): string
    {
        return substr($this->text, $this->offset1, $this->offset2 - $this->offset1);
    }

    public function getOffset1(): int
    {
        return $this->offset1;
    }

    public function getOffset2(): int
    {
        return $this->offset2;
    }

    /**
     * @inheritDoc
     */
    public function equals(EquatableInterface $object): bool
    {
        if ($object instanceof self === false) {
            return false;
        }

        if ($this === $object) {
            return true;
        }

        return $this->hash === $object->hash && $this->getContent() === $object->getContent();
    }

    public function hashCode(): int
    {
        return $this->hash;
    }
}
