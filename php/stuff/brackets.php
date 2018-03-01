<?php
namespace stuff;

function brackets($string)
{
    $array = str_split($string);
    $position = 0;
    $bracketsC = [];
    $bracketsC1 = [']'=>'[','}'=>'{',')'=>'('];
    foreach ($array as $key) {
        if (array_key_exists($key, $bracketsC1) && array_pop($bracketsC) == $bracketsC1[$key]) {
            continue;
        } elseif (!array_key_exists($key, $bracketsC1)) {
            $bracketsC[] = $key;
            continue;
        } else {
            return 'NO';
        }
    }
    return 'YES';
}
