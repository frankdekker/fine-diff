<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Entity;

class NewLineChunk implements InlineChunk
{
    public function __construct(private int $offset)
    {
    }

    public function getOffset1(): int
    {
        return $this->offset;
    }

    public function getOffset2(): int
    {
        return $this->offset + 1;
    }

    public function equals(EquatableInterface $object): bool
    {
        return $object instanceof self;
    }
}
