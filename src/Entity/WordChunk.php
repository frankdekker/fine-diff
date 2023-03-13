<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 Digital Revolution BV (123inkt.nl). Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff\Entity;

use DR\JBDiff\Entity\Character\CharSequenceInterface;

class WordChunk implements InlineChunk
{
    private string $subtext;

    public function __construct(private CharSequenceInterface $text, private int $offset1, private int $offset2)
    {
        $this->subtext = (string)$this->text->subSequence($this->offset1, $this->offset2);
    }

    public function getContent(): string
    {
        return $this->subtext;
    }

    public function getOffset1(): int
    {
        return $this->offset1;
    }

    public function getOffset2(): int
    {
        return $this->offset2;
    }

    public function equals(EquatableInterface $object): bool
    {
        if ($object instanceof self === false) {
            return false;
        }

        if ($this === $object) {
            return true;
        }

        return $this->subtext === $object->subtext;
    }
}
