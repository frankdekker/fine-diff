<?php
declare(strict_types=1);

namespace FDekker\Entity;

use FDekker\Entity\Character\CharSequenceInterface;

class WordChunk implements InlineChunk
{
    public function __construct(private CharSequenceInterface $text, private int $offset1, private int $offset2, private int $hash)
    {
    }

    public function getContent(): string
    {
        return (string)$this->text->subSequence($this->offset1, $this->offset2);
    }

    public function getOffset1(): int
    {
        return $this->offset1;
    }

    public function getOffset2(): int
    {
        return $this->offset2;
    }

    public function equals(EquatableInterface $object): bool
    {
        if ($object instanceof self === false) {
            return false;
        }

        if ($this === $object) {
            return true;
        }

        return $this->hash === $object->hash &&
            $this->text->subSequence($this->offset1, $this->offset2) === $object->text->subSequence($this->offset1, $this->offset2);
    }

    public function hashCode(): int
    {
        return $this->hash;
    }
}
