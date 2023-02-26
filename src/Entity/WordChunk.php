<?php
declare(strict_types=1);

namespace FDekker\Entity;

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

    public function equals(InlineChunk $chunk): bool
    {
        if ($chunk instanceof self === false) {
            return false;
        }

        if ($this === $chunk) {
            return true;
        }

        return $this->hash === $chunk->hash && $this->getContent() === $chunk->getContent();
    }

    public function hashCode(): int
    {
        return $this->hash;
    }
}
