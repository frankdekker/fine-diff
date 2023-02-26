<?php
declare(strict_types=1);

namespace FDekker\Entity;

interface InlineChunk
{
    public function getOffset1(): int;

    public function getOffset2(): int;

    public function equals(InlineChunk $chunk): bool;

    public function hashCode(): int;
}
