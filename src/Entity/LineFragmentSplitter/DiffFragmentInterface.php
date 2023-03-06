<?php
declare(strict_types=1);

namespace FDekker\Entity\LineFragmentSplitter;

/**
 * Modified part of the text
 */
interface DiffFragmentInterface
{
    public function getStartOffset1(): int;

    public function getEndOffset1(): int;

    public function getStartOffset2(): int;

    public function getEndOffset2(): int;
}
