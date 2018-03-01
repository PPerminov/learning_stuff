<?php
namespace stuff;

function deps(array $graph)
{
    $result=[];
    $insert=function ($name, $place) use (&$result) {
        $count=count($result) - 1;
        $array_temp1=[];
        $array_temp2=[];
        if (in_array($pac, $result)) {
            return false;
        }
        for ($i = $place;$i <= $count;$i++) {
            $array_temp2[]=$result[$i];
        }
        for ($i = 0;$i < $place;$i++) {
            $array_temp1[]=$result[$i];
        }
        $result=[];
        foreach ($array_temp1 as $key) {
            $result[]=$key;
        }
        $result[]=$name;
        foreach ($array_temp2 as $key) {
            $result[]=$key;
        }
    };



    foreach ($graph as $key => $value) {
        if ($value == null and (!in_array($key, $result))) {
            $result[]=$key;
            continue;
        }

        if (in_array($key, $result) and $value != null) {
            $place=array_search($key, $result);
            $result_tmp=[];
            foreach ($value as $value1) {
                if (!in_array($value1, $result)) {
                    $insert($value1, $place);
                }
            }
        }

        if ($value != null) {
            foreach ($value as $value1) {
                if (!in_array($value1, $result)) {
                    $result[]=$value1;
                }
            }
            if (!in_array($key, $result)) {
                $result[]=$key;
            }
        }
    }

    return $result;
}




$graph = [
    'mongo' => [],
    'tzinfo' => ['thread_safe'],
    'uglifier' => ['execjs'],
    'execjs' => ['thread_safe', 'json'],
    'redis' => []
];
