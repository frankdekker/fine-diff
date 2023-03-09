<?php
declare(strict_types=1);

namespace FDekker\Entity\Character;

use FDekker\Entity\EquatableInterface;

class MergingCharSequence implements CharSequenceInterface
{
    public function __construct(private readonly CharSequenceInterface $s1, private readonly CharSequenceInterface $s2)
    {
    }

    public function length(): int
    {
        return $this->s1->length() + $this->s2->length();
    }

    public function isEmpty(): bool
    {
        return $this->s1->isEmpty() && $this->s2->isEmpty();
    }

    public function charAt(int $index): string
    {
        if ($index < $this->s1->length()) {
            return $this->s1->charAt($index);
        }

        return $this->s2->charAt($index - $this->s1->length());
    }

    /**
     * @return string[]
     */
    public function chars(): array
    {
        return array_merge($this->s1->chars(), $this->s2->chars());
    }

    public function subSequence(int $start, int $end): CharSequenceInterface
    {
        if ($start === 0 && $end === $this->length()) {
            return $this;
        }

        $firstLength = $this->s1->length();

        if ($start < $firstLength && $end < $firstLength) {
            return $this->s1->subSequence($start, $end);
        }

        if ($start >= $firstLength && $end >= $firstLength) {
            return $this->s2->subSequence($start - $firstLength, $end - $firstLength);
        }

        return new MergingCharSequence($this->s1->subSequence($start, $firstLength), $this->s2->subSequence(0, $end - $firstLength));
    }

    public function equals(EquatableInterface $object): bool
    {
        return $object instanceof CharSequenceInterface && (string)$this === (string)$object;
    }

    public function __toString(): string
    {
        return $this->s1 . $this->s2;
    }
}
