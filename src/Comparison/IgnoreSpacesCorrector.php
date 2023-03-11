<?php
declare(strict_types=1);

namespace FDekker\Comparison;

use FDekker\Diff\DiffIterableUtil;
use FDekker\Diff\Iterable\DiffIterableInterface;
use FDekker\Entity\Character\CharSequenceInterface;
use FDekker\Entity\Range;
use FDekker\Util\TrimUtil;

class IgnoreSpacesCorrector
{
    /** @var Range[] */
    private array $changes = [];

    public function __construct(
        private readonly DiffIterableInterface $iterable,
        private readonly CharSequenceInterface $text1,
        private readonly CharSequenceInterface $text2
    ) {
    }

    public function build(): DiffIterableInterface
    {
        foreach ($this->iterable->changes() as $range) {
            $expanded = TrimUtil::expandWhitespaces($this->text1, $this->text2, $range);
            $trimmed = TrimUtil::trimWhitespacesRange($this->text1, $this->text2, $expanded);

            if ($trimmed->isEmpty() || TrimUtil::isEqualsIgnoreWhitespacesRange($this->text1, $this->text2, $trimmed)) {
                continue;
            }

            $this->changes[] = $trimmed;
        }

        return DiffIterableUtil::createFromRanges($this->changes, $this->text1->length(), $this->text2->length());
    }
}
