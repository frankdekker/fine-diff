<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

abstract class AbstractChangeDiffIterable implements DiffIterableInterface
{
    public function __construct(private readonly int $length1, private readonly int $length2)
    {
    }

    public function getLength1(): int
    {
        return $this->length1;
    }

    public function getLength2(): int
    {
        return $this->length2;
    }

    /**
     * @inheritDoc
     */
    public function changes(): CursorIteratorInterface
    {
        return new ChangedIterator($this->createChangeIterable());
    }

    /**
     * @inheritDoc
     */
    public function unchanged(): CursorIteratorInterface
    {
        return new UnchangedIterator($this->createChangeIterable(), $this->length1, $this->length2);
    }

    abstract protected function createChangeIterable(): ChangeIterableInterface;
}
