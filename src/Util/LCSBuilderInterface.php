<?php
declare(strict_types=1);

namespace DR\JBDiff\Util;

interface LCSBuilderInterface
{
    public function addEqual(int $length): void;
    public function addChange(int $first, int $second): void;
}
