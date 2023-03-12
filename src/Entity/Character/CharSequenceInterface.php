<?php
declare(strict_types=1);

namespace DR\JBDiff\Entity\Character;

use DR\JBDiff\Entity\EquatableInterface;
use Stringable;

interface CharSequenceInterface extends Stringable, EquatableInterface
{
    public function length(): int;

    public function isEmpty(): bool;

    /**
     * @return string[]
     */
    public function chars(): array;

    public function charAt(int $index): string;

    public function subSequence(int $start, int $end): CharSequenceInterface;
}
