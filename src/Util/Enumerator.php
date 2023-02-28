<?php
declare(strict_types=1);

namespace FDekker\Util;

use FDekker\Entity\EquatableInterface;

class Enumerator
{
    /** @var array<int, EquatableInterface> */
    private array $myNumbers = [];

    private int $myNextNumber = 1;

    /**
     * @param EquatableInterface[] $objects
     *
     * @return int[]
     */
    public function enumerate(array $objects, int $startShift, int $endCut): array
    {
        $len = count($objects) - $endCut;

        $idx = [];
        for ($i = $startShift; $i < $len; $i++) {
            $idx[] = $this->enumerateObject($objects[$i]);
        }

        return $idx;
    }

    public function enumerateObject(EquatableInterface $object): int
    {
        $number = $this->getInt($object);
        if ($number === 0) {
            $number                   = $this->myNextNumber++;
            $this->myNumbers[$number] = $object;
        }

        return $number;
    }

    private function getInt(EquatableInterface $object): int
    {
        foreach ($this->myNumbers as $number => $entry) {
            if ($entry->equals($object)) {
                return $number;
            }
        }

        return 0;
    }
}
