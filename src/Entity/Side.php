<?php
declare(strict_types=1);

namespace FDekker\Entity;

use InvalidArgumentException;

class Side
{
    private const LEFT  = 0;
    private const RIGHT = 1;

    private function __construct(private readonly int $index)
    {
    }

    public static function fromIndex(int $index): Side
    {
        return match ($index) {
            self::LEFT  => self::left(),
            self::RIGHT => self::right(),
            default     => throw new InvalidArgumentException('Invalid index: ' . $index),
        };
    }

    public static function fromLeft(bool $isLeft): Side
    {
        return $isLeft ? self::left() : self::right();
    }

    public static function fromRight(bool $isRight): Side
    {
        return $isRight ? self::right() : self::left();
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function isLeft(): bool
    {
        return $this->index === self::LEFT;
    }

    public function other(bool $other = true): Side
    {
        if ($other === false) {
            return $this;
        }

        return $this->isLeft() ? self::right() : self::left();
    }

    /**
     * @template T
     *
     * @param T $left
     * @param T $right
     *
     * @return T
     */
    public function select(mixed $left, mixed $right): mixed
    {
        return $this->isLeft() ? $left : $right;
    }

    private static function left(): Side
    {
        static $left;

        return $left ??= new Side(self::LEFT);
    }

    private static function right(): Side
    {
        static $right;

        return $right ??= new Side(self::RIGHT);
    }
}
