<?php
declare(strict_types=1);

namespace FDekker\Tests\Util;

use FDekker\Entity\WordChunk;
use FDekker\Util\Enumerator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Enumerator::class)]
class EnumeratorTest extends TestCase
{
    public function testEnumerate(): void
    {
        $wordA = new WordChunk('public function int', 0, 6, 3317543529);
        $wordB = new WordChunk('public function int', 7, 15, 1380938712);
        $wordC = new WordChunk('public function int', 16, 19, 104431);

        $wordD = new WordChunk('public int test', 0, 6, 3317543529);
        $wordE = new WordChunk('public int test', 7, 10, 104431);
        $wordF = new WordChunk('public int test', 11, 15, 3556498);

        $enumerator = new Enumerator();
        $resultA = $enumerator->enumerate([$wordA, $wordB, $wordC], 1, 0);
        $resultB = $enumerator->enumerate([$wordD, $wordE, $wordF], 1, 0);

        static::assertSame([1,2], $resultA);
        static::assertSame([2,3], $resultB);
    }
}
