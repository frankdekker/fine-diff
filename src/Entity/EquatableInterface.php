<?php
declare(strict_types=1);

namespace FDekker\Entity;

interface EquatableInterface
{
    public function equals(EquatableInterface $object): bool;
}
