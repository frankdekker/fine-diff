<?php
declare(strict_types=1);

namespace FDekker\Diff;

use FDekker\Diff;
use FDekker\Diff\Iterable\DiffChangeDiffIterable;
use FDekker\Diff\Iterable\DiffIterableInterface;
use FDekker\Diff\Iterable\FairDiffIterableInterface;
use FDekker\Diff\Iterable\FairDiffIterableWrapper;
use FDekker\Entity\Change;

class DiffIterableUtil
{
    /**
     * @throws DiffToBigException
     */
    public static function diff(array $chunks1, array $chunks2): object
    {
        try {
            $change = (new Diff())->buildChanges($chunks1, $chunks2);

            return self::fair(self::create($change, count($chunks1), count($chunks2)));
        } catch (FilesTooBigForDiffException $e) {
            throw new DiffToBigException(previous: $e);
        }
    }

    public static function create(Change $change, int $length1, int $length2): DiffIterableInterface
    {
        return new DiffChangeDiffIterable($change, $length1, $length2);
    }

    public static function fair(DiffIterableInterface $iterable): FairDiffIterableInterface
    {
        if ($iterable instanceof FairDiffIterableInterface) {
            return $iterable;
        }

        return new FairDiffIterableWrapper($iterable);
    }
}
