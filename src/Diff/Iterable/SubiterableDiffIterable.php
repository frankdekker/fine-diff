<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

class SubiterableDiffIterable extends AbstractChangeDiffIterable
{
    public function __construct(
        private readonly DiffIterableInterface $iterable,
        private readonly int $start1,
        private readonly int $end1,
        private readonly int $start2,
        private readonly int $end2
    ) {
        parent::__construct($end1 - $start1, $end2 - $start2);
    }

    protected function createChangeIterable(): ChangeIterableInterface
    {
        return new SubiterableChangeIterable($this->iterable, $this->start1, $this->end1, $this->start2, $this->end2);
    }
}
