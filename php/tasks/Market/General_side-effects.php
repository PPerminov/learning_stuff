<?php
namespace Perminov\General;

require 'General.php';

function toTree($list, $deepness=0,$accum='')
{
    if (isempty($list)) {
        return $accum;
    }
    $currentDeepness=function () use ($deepness) {
        $symbol = '';
        while ($deepness >= 0) {
            $symbol .= '--';
            $deepness--;
        }
        return $symbol;
    };
    $currentLine = head($list);
    if (isList($currentLine)) {
        $accum.=toTree($currentLine, $deepness+1);
    } else {
        $accum.=$currentString = $currentDeepness() . $currentLine . PHP_EOL;
    }
    return toTree(tail($list), $deepness,$accum);
}


$test_object = l(1, 2, l(11, 12, l(13, 14)), 4, 5, l(11, 12, l(13, 14)), l(11, 12, l(13, l(11, 12, l(13, 14)))), 7, 8, 9);
echo toTree($test_object);
