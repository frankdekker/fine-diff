<?php

declare(strict_types=1);

use DR\JBDiff\ComparisonPolicy;
use DR\JBDiff\Diff\ByWordRt;
use DR\JBDiff\Entity\Character\CharSequence;
use DR\JBDiff\Formatter\LineBlockHtmlFormatter;
use DR\JBDiff\Formatter\LineBlockIterator;

require_once '../vendor/autoload.php';

$text1 = '    public function findBy(array $predicates, SortInterface $sort, ConnectionConfig|string $database, bool $convertToUtf8 = true): array
    {
        return $this->persistence->findBy($predicates, $sort, $database, $convertToUtf8);
';
$text2 = '    public function findBy(array $predicates, SortInterface $sort, ConnectionConfig|string $database, string $encoding = \'utf8\'): array
    {
        if ($encoding !== \'latin1\' && $encoding !== \'utf8\') {
            throw new InvalidArgumentException(\'Expecting encoding to be `latin1` or `utf8`\');
        }

        return $this->persistence->findBy($predicates, $sort, $database, $encoding);
';

$lineBlocks = ByWordRt::compareAndSplit(CharSequence::fromString($text1), CharSequence::fromString($text2), ComparisonPolicy::DEFAULT);

echo (new LineBlockHtmlFormatter())->format(new LineBlockIterator($text1, $text2, $lineBlocks));
