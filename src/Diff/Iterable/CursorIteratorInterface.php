<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 Digital Revolution BV (123inkt.nl). Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

use IteratorAggregate;

/**
 * @template T
 * @extends IteratorAggregate<T>
 */
interface CursorIteratorInterface extends IteratorAggregate
{
    public function hasNext(): bool;

    /**
     * @return T
     */
    public function next(): mixed;
}
