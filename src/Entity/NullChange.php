<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Modification copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Entity;

class NullChange extends Change
{
    public function __construct()
    {
        parent::__construct(0, 0, 0, 0);
    }

    public function isNull(): bool
    {
        return true;
    }
}
