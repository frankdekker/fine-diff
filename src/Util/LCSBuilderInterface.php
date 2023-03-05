<?php
declare(strict_types=1);

namespace FDekker\Util;

interface LCSBuilderInterface
{
    public function addEqual(int $length): void;
    public function addChange(int $first, int $second): void;
}
