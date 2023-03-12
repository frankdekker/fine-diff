<?php
declare(strict_types=1);

namespace DR\JBDiff\Entity;

interface InlineChunk extends EquatableInterface
{
    public function getOffset1(): int;

    public function getOffset2(): int;
}
