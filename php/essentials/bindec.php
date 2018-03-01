<?php
namespace essentials\convert;

function bintodec($bin)
{
    $dataarray=array_reverse(str_split($bin));
    if (array_sum($dataarray) > count($dataarray) + 1) {
        return false;
    }
    $power=0;
    $result=0;
    foreach ($dataarray as $bit) {
        $result = pow(2, $power)*$bit + $result;
        $power++;
    }


    return number_format($result, 0, '', '') + 0;
}


function dectobin($number, $result="")
{
    while ($number > 0) {
        $de=$number % 2;
        $result = $de . $result;
        $number=($number - ($number %2))/2;
    }
    return $result;
}
