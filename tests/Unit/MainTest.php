<?php
declare(strict_types=1);

namespace FDekker\Tests;

use FDekker\ByWord;
use FDekker\Diff;
use FDekker\Diff\FilesTooBigForDiffException;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    /**
     * @throws FilesTooBigForDiffException
     */
    public function testMain(): void {
        $inlineChunksA = ByWord::getInlineChunks("public function int bar");
        $inlineChunksB = ByWord::getInlineChunks("public foo int test");

        $changes = (new Diff())->buildChanges($inlineChunksA, $inlineChunksB);
    }

}
