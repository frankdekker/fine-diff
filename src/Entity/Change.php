<?php
declare(strict_types=1);

namespace FDekker\Entity;

class Change
{
    /**
     * @param int         $line0    Lines of file 0 changed here.
     * @param int         $line1    Lines of file 1 changed here.
     * @param int         $deleted  Line number of 1st deleted line.
     * @param int         $inserted Line number of 1st inserted line.
     */
    public function __construct(
        public readonly int $line0,
        public readonly int $line1,
        public readonly int $deleted,
        public readonly int $inserted,
        //public readonly ?Change $link = null
    )
    {
    }

    public function isNull(): bool
    {
        return false;
    }

    public function __toString()
    {
        return sprintf("change[inserted=%d, deleted=%d, line0=%d, line1=%d]", $this->inserted, $this->deleted, $this->line0, $this->line1);
    }

    ///**
    // * @return Change[]
    // */
    //public function toArray(): array
    //{
    //    $result = [];
    //    for ($current = $this; $current !== null; $current = $current->link) {
    //        $result[] = $current;
    //    }
    //
    //    return $result;
    //}
}