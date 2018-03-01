<?php
namespace essentials\network;

include 'bindec.php';


function mask_to_bits(string $mask)
{
    $exploded=explode(".", $mask);

    for ($position = 0; $position < count($exploded) - 1; $position ++) {
        if ($exploded[$position] < $exploded[$position+1]) {
            return "Error! This is SHIT not MASK";
        }
    }
    $mapped=array_map('essentials\convert\dectobin', $exploded);
    foreach ($mapped as $value) {
        $temp_result="";
        $sum=array_sum(str_split($value));
        for ($bit=0;$bit < 8; $bit++) {
            if ($sum > 0) {
                $temp_result=$temp_result . "1";
            } else {
                $temp_result=$temp_result . "0";
            }
            --$sum;
        }
        $restored=$temp_result;
        if (\essentials\convert\bintodec($temp_result) != \essentials\convert\bintodec($value)) {
            return "Bad MASK!!!!";
        }
    }
    return array_sum(str_split(array_sum($mapped)));
}
function bits_to_mask($bits)
{
    $remained=$bits;
    $temp_result="";

    for ($bit=0;$bit < 32; $bit++) {
        if ($remained > 0) {
            $temp_result=$temp_result . "1";
        } else {
            $temp_result=$temp_result . "0";
        }
        --$remained;
    }
    return implode(array_map('\essentials\convert\bintodec', str_split($temp_result, 8)), ".");
}
