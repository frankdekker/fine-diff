<?php
declare(strict_types=1);

namespace FDekker\Entity;

class NullChange extends Change
{
    public function __construct()
    {
        parent::__construct(0, 0, 0, 0);
    }

    public function isNull(): bool
    {
        return true;
    }
}
