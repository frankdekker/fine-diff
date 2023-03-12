<?php
declare(strict_types=1);

namespace FDekker\Entity;

interface InlineChunk extends EquatableInterface
{
    public function getOffset1(): int;

    public function getOffset2(): int;

    public function hashCode(): float;
}
