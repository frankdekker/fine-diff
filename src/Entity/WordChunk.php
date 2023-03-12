<?php
declare(strict_types=1);

namespace FDekker\Entity;

use FDekker\Entity\Character\CharSequenceInterface;

class WordChunk implements InlineChunk
{
    public function __construct(private CharSequenceInterface $text, private int $offset1, private int $offset2, private float $hash)
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

        if ($this->hash !== $object->hash) {
            return false;
        }

        $chars1 = array_slice($this->text->chars(), $this->offset1, $this->offset2 - $this->offset1);
        $chars2 = array_slice($object->text->chars(), $object->offset1, $object->offset2 - $object->offset1);

        return $chars1 === $chars2;
    }

    public function hashCode(): float
    {
        return $this->hash;
    }
}
