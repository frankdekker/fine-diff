<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

interface ChangeIterableInterface
{
    public function valid(): bool;

    public function next(): void;

    public function getStart1(): int;

    public function getStart2(): int;

    public function getEnd1(): int;

    public function getEnd2(): int;
}
