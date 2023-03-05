<?php
declare(strict_types=1);

namespace FDekker\Diff;

use FDekker\Diff;

class DiffIterableUtil
{
    /**
     * @throws DiffToBigException
     */
    public static function diff(array $chunks1, array $chunks2): object
    {
        try {
            $change = (new Diff())->buildChanges($chunks1, $chunks2);
        } catch (FilesTooBigForDiffException $e) {
            throw new DiffToBigException(previous: $e);
        }
    }
}
