<?php
// Copyright 2000-2019 JetBrains s.r.o. Use of this source code is governed by the Apache 2.0 license that can be found in the LICENSE file.
// Copyright 2023 123inkt. Use of this source code is governed by the Apache 2.0 license.
declare(strict_types=1);

namespace DR\JBDiff;

use DR\JBDiff\Diff\DiffIterableUtil;
use DR\JBDiff\Diff\DiffToBigException;
use DR\JBDiff\Diff\Iterable\FairDiffIterableInterface;
use DR\JBDiff\Diff\Matcher\ChangeBuilder;
use DR\JBDiff\Entity\Character\CharSequenceInterface;
use DR\JBDiff\Entity\Character\CharSequenceInterface as CharSequence;
use DR\JBDiff\Entity\Character\CodePointsOffsets;
use DR\JBDiff\Util\Character;
use IntlChar;

class ByCharRt
{
    /**
     * @throws DiffToBigException
     */
    public static function comparePunctuation(CharSequence $text1, CharSequence $text2): FairDiffIterableInterface
    {
        $chars1 = self::getPunctuationChars($text1);
        $chars2 = self::getPunctuationChars($text2);

        $nonSpaceChanges = DiffIterableUtil::diff($chars1->codePoints, $chars2->codePoints);

        return self::transferPunctuation($chars1, $chars2, $text1, $text2, $nonSpaceChanges);
    }

    public static function getPunctuationChars(CharSequenceInterface $text): CodePointsOffsets
    {
        $codePoints = [];
        $offsets    = [];

        foreach ($text->chars() as $i => $char) {
            $codePoint = IntlChar::ord($char);
            // TODO does this correctly work?
            // TODO and move this inside CharSequence to store the already known punctuations
            if (Character::isPunctuation($codePoint)) {
                $codePoints[] = $codePoint;
                $offsets[]    = $i;
            }
        }

        return new CodePointsOffsets($codePoints, $offsets);
    }

    public static function transferPunctuation(
        CodePointsOffsets $chars1,
        CodePointsOffsets $chars2,
        CharSequence $text1,
        CharSequence $text2,
        FairDiffIterableInterface $changes
    ): FairDiffIterableInterface {
        $builder = new ChangeBuilder($text1->length(), $text2->length());

        foreach ($changes->unchanged() as $range) {
            $count = $range->end1 - $range->start1;
            for ($i = 0; $i < $count; $i++) {
                // Punctuation code points are always 1 char
                $offset1 = $chars1->offsets[$range->start1 + $i];
                $offset2 = $chars2->offsets[$range->start2 + $i];
                $builder->markEqualCount($offset1, $offset2);
            }
        }

        return DiffIterableUtil::fair($builder->finish());
    }
}
