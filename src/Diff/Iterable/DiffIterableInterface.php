<?php
declare(strict_types=1);

namespace FDekker\Diff\Iterable;

use Symfony\Component\Validator\Constraints\Range;

interface DiffIterableInterface
{
    public function getLength1(): int;
    public function getLength2(): int;

    /**
     * @return CursorIteratorInterface<Range>
     */
    public function changes(): CursorIteratorInterface;

    /**
     * @return CursorIteratorInterface<Range>
     */
    public function unchanged(): CursorIteratorInterface;


}
