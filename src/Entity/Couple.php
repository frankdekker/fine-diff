<?php
declare(strict_types=1);

namespace FDekker\Entity;

/**
 * @template T
 * @extends Pair<T, T>
 */
class Couple extends Pair
{
    /**
     * @param T $first
     * @param T $second
     *
     * @return Couple<T>
     */
    public static function of(mixed $first, mixed $second): Couple
    {
        return new Couple($first, $second);
    }
}
