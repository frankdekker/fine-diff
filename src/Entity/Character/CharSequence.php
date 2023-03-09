<?php
declare(strict_types=1);

namespace FDekker\Entity\Character;

use FDekker\Entity\EquatableInterface;
use function count;
use function assert;

class CharSequence implements CharSequenceInterface
{
    /**
     * @param string[] $chars
     */
    private function __construct(private readonly array $chars)
    {
    }

    public function length(): int
    {
        return count($this->chars);
    }

    public function charAt(int $index): string
    {
        assert(isset($this->chars[$index]));

        return $this->chars[$index];
    }

    public function isEmpty(): bool
    {
        return count($this->chars) === 0;
    }

    public function subSequence(int $start, int $end): CharSequenceInterface
    {
        return new CharSequence(array_slice($this->chars, $start, $end - $start));
    }

    public function __toString(): string
    {
        return implode('', $this->chars);
    }

    public static function fromString(string $string): self
    {
        $chars = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        assert($chars !== false);

        return new CharSequence($chars);
    }

    public function equals(EquatableInterface $object): bool
    {
        if ($object instanceof self === false) {
            return false;
        }

        return $object === $this || $this->chars === $object->chars;
    }
}
