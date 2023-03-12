<?php
declare(strict_types=1);

namespace DR\JBDiff\Enum;

enum ComparisonPolicy
{
    case DEFAULT;
    case TRIM_WHITESPACES;
    case IGNORE_WHITESPACES;
}
