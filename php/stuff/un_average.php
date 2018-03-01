<?php
namespace stuff;

function un_average($aver, $count, $min = 1)
{
    $array = [];
    $arrayline = [];
    $arcount = $count -1;
    $avnum = $aver * $count;

    for ($f = 0 ; $f <= $arcount ; $f++) {
        $array[$f] = $aver;
    }
    for ($i = 0; $i < $arcount  ; $i++) {
        $delta = $array[$i] - $min;
        $multip = $delta / ($arcount - $i);
        $array[$i] = $min;
        for ($f = $i; $f <= $arcount ; $f++) {
            $array[$f] = $array[$f] + $multip;
        }
    }
    return $array[$arcount];
}

echo "This is examle:\nWe have average of some numbers equal 55 and we know that there are 15 numbers.\nIf we assume that all numbers (except one) will be minimal (6 for this example) then the last must be " . un_average(55, 15,6) . " for those average\n";
