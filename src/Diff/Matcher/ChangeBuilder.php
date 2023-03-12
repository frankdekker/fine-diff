<?php
declare(strict_types=1);

namespace DR\JBDiff\Diff\Matcher;

use DR\JBDiff\Diff\DiffIterableUtil;
use DR\JBDiff\Diff\Iterable\DiffIterableInterface;
use DR\JBDiff\Entity\Change;

class ChangeBuilder extends AbstractChangeBuilder
{
    private ?Change $firstChange = null;
    private ?Change $lastChange  = null;

    protected function addChange(int $start1, int $start2, int $end1, int $end2): void
    {
        $change = new Change($start1, $start2, $end1 - $start1, $end2 - $start2);
        if ($this->lastChange !== null) {
            $this->lastChange->link = $change;
        } else {
            $this->firstChange = $change;
        }
        $this->lastChange = $change;
    }

    public function finish(): DiffIterableInterface
    {
        $this->doFinish();

        return DiffIterableUtil::create($this->firstChange, $this->getLength1(), $this->getLength2());
    }
}
