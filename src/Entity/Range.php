<?php
declare(strict_types=1);

namespace FDekker\Entity;

use Stringable;

class Range implements EquatableInterface, Stringable
{
    public function __construct(public readonly int $start1, public readonly int $end1, public readonly int $start2, public readonly int $end2)
    {
    }

    public function isEmpty(): bool
    {
        return $this->start1 === $this->end1 && $this->start2 === $this->end2;
    }

    public function equals(EquatableInterface $object): bool
    {
        if ($object instanceof self === false) {
            return false;
        }

        if ($this === $object) {
            return true;
        }

        return $this->start1 === $object->start1
            && $this->end1 === $object->end1
            && $this->start2 === $object->start2
            && $this->end2 === $object->end2;
    }

    public function hashCode(): int
    {
        // TODO is this method necessary?
        return 0;
    }

    public function __toString(): string
    {
        return "[" . $this->start1 . ", " . $this->end1 . "] - [" . $this->start2 . ", " . $this->end2 . "]";
    }
}