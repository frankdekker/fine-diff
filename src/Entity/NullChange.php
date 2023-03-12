<?php
declare(strict_types=1);

namespace DR\JBDiff\Entity;

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
