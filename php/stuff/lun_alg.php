<?php
function cyklops($array)
{
    sort($array);
    print_r($array);
    $tmp1=0;
    $count=0;

    for ($i=0;$i<count($array);$i++) {
        if ($i==0) {
            $tmp1++;
            continue;
        }
        $tmp=abs($array[$i] - $array[$i-1]);
        if ($tmp == 1 or $tmp == 0) {
            if ($tmp1 == 1) {
                $count++;
                $tmp1=0;
            } elseif ($tmp1 == 0) {
                $tmp1++;
            }
        } else {
            if ($tmp1 == 1) {
                $count++;
            } elseif ($tmp1 == 0) {
                $tmp1++;
            }
        }
    }
    if ($tmp1 == 1) {
        $count++;
    }


    return $count;
}
