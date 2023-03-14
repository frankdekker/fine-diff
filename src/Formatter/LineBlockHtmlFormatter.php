<?php

declare(strict_types=1);

namespace DR\JBDiff\Formatter;

class LineBlockHtmlFormatter
{
    public function format(LineBlockTextIterator $iterator): string
    {
        $html = "<!DOCTYPE html>\n";
        $html .= "<html lang=\"en\">\n";
        $html .= "<head></head>\n";
        $html .= "<body>\n";

        $html .= '<pre style="font-family: Monospaced, \'Courier New\'">';
        foreach ($iterator as [$change, $text]) {
            if ($change === LineBlockTextIterator::TEXT_UNCHANGED) {
                $html .= htmlspecialchars($text);
            } elseif ($change === LineBlockTextIterator::TEXT_ADDED) {
                $html .= '<span style="background-color: #A6F3A6">' . htmlspecialchars($text) . '</span>';
            } elseif ($change === LineBlockTextIterator::TEXT_REMOVED) {
                $html .= '<span style="background-color: #F8CBCB">' . htmlspecialchars($text) . '</span>';
            }
        }
        $html .= "</pre>\n";

        $html .= "</body>\n";
        $html .= "</html>\n";

        return $html;
    }
}
