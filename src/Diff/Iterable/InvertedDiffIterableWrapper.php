<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

class InvertedDiffIterableWrapper implements DiffIterableInterface
{
    public function __construct(private readonly DiffIterableInterface $iterable)
    {
    }

    public function getLength1(): int
    {
        return $this->iterable->getLength1();
    }

    public function getLength2(): int
    {
        return $this->iterable->getLength2();
    }

    public function changes(): CursorIteratorInterface
    {
        return $this->iterable->unchanged();
    }

    public function unchanged(): CursorIteratorInterface
    {
        return $this->iterable->changes();
    }
}
