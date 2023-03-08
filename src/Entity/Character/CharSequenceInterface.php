<?php
declare(strict_types=1);

namespace FDekker\Entity\Character;

use Stringable;

interface CharSequenceInterface extends Stringable
{
    public function length(): int;

    public function isEmpty(): bool;

    public function charAt(int $index): string;

    public function subSequence(int $start, int $end): CharSequenceInterface;
}
