<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
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
