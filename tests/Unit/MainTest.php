<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWordRt;
use FDekker\Diff\DiffToBigException;
use FDekker\Entity\Character\CharSequence;
use FDekker\Enum\ComparisonPolicy;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    /**
     * @throws DiffToBigException
     */
    public function testMain(): void
    {
        $text1 = CharSequence::fromString("public function int bar");
        $text2 = CharSequence::fromString("public foo int test");

        ByWordRt::compareAndSplit($text1, $text2, ComparisonPolicy::DEFAULT);
    }
}
