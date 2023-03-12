<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Entity\LineFragmentSplitter;

/**
 * Modified part of the text
 */
interface DiffFragmentInterface
{
    public function getStartOffset1(): int;

    public function getEndOffset1(): int;

    public function getStartOffset2(): int;

    public function getEndOffset2(): int;
}
