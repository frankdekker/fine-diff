<?php
declare(strict_types=1);

namespace FDekker\Entity;

/**
 * @template T of EquatableInterface
 */
interface EquatableInterface
{
    /**
     * @param T $object
     */
    public function equals(EquatableInterface $object): bool;
}
