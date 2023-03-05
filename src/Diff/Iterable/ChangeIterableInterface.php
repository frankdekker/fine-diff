<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

interface ChangeIterableInterface
{
    public function isValid(): bool;

    public function next(): void;

    public function getStart1(): int;

    public function getStart2(): int;

    public function getEnd1(): int;

    public function getEnd2(): int;
}
