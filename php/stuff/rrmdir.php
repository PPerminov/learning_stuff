<?php

function summaryRanges($array)
{
    $new=1;
    $currentArray=[];
    $result=[];
    foreach ($array as $key) {
        // echo $key . "\n";
        if ($new == 1) {
            $currentArray[]=$key;
            $new = 0;
            continue;
        }
        if ($key - 1 == $currentArray[count($currentArray) - 1]) {
            $currentArray[]=$key;
            continue;
        }
        if (count($currentArray) > 1) {
            // echo count($currentArray);
            $result[]=$currentArray[0] . "->" . $currentArray[count($currentArray) - 1];
            $currentArray=[];
            $currentArray[]=$key;
            continue;
        }
        $currentArray=[];
        $new=1;
    }
    if ($key - 1 == $currentArray[count($currentArray) - 1]) {
        $currentArray[]=$key;
    } elseif (count($currentArray) > 1) {
        $result[]=$currentArray[0] . "->" . $currentArray[count($currentArray) - 1];
    } else {
        $new=1;
    }
    return $result;
}
