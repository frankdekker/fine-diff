<?php
// Copyright 2000-2021 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 Digital Revolution BV (123inkt.nl). Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Entity\LineFragmentSplitter;

class DiffFragment implements DiffFragmentInterface
{
    public function __construct(
        private readonly int $startOffset1,
        private readonly int $endOffset1,
        private readonly int $startOffset2,
        private readonly int $endOffset2
    ) {
        assert($startOffset1 !== $endOffset1 || $startOffset2 !== $endOffset2);
        assert($startOffset1 <= $endOffset1 && $startOffset2 <= $endOffset2);
    }

    public function getStartOffset1(): int
    {
        return $this->startOffset1;
    }

    public function getEndOffset1(): int
    {
        return $this->endOffset1;
    }

    public function getStartOffset2(): int
    {
        return $this->startOffset2;
    }

    public function getEndOffset2(): int
    {
        return $this->endOffset2;
    }
}
