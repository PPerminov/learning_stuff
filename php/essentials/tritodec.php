<?php

function tri_to_dec(string $tri)
{
    $sum=0;
    $mum=0;
    $data_array=str_split($tri);
    for ($set=0;$set < count($data_array);$set++) {
        if ($data_array[$set] == "-") {
            $set++;
            $tmp_array[]=0-$data_array[$set];
        } else {
            $tmp_array[]=$data_array[$set] ;
        }
    }
    $data_array=$tmp_array;
    if (array_sum($data_array) > count($data_array) + 1) {
        return false;
    }
    foreach (array_reverse($data_array) as $tri) {
        $sum=$sum+pow(3, $mum)*$tri;
        $mum++;
    }
    return $sum;
}
