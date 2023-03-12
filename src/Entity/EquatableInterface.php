<?php
declare(strict_types=1);

namespace DR\JBDiff\Entity;

interface EquatableInterface
{
    public function equals(EquatableInterface $object): bool;
}
