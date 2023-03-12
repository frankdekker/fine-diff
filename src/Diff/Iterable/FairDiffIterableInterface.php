<?php
declare(strict_types=1);

namespace DR\JBDiff\Diff\Iterable;

/**
 * Marker interface indicating that elements are compared one-by-one.
 * <p>
 * If range [a, b) is equal to [a', b'), than element(a + i) is equal to element(a' + i) for all i in [0, b-a)
 * Therefore, {@link self::unchanged} ranges are guaranteed to have {@link DiffIterableUtil::getRangeDelta(Range)} equal to 0.
 *
 * @see DiffIterableUtil::fair(DiffIterableInterface)
 */
interface FairDiffIterableInterface extends DiffIterableInterface
{
}
