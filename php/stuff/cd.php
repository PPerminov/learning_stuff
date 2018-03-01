<?php
function cd($current, $move)
{
    $moveArray=explode('/', $move);
    if ($moveArray[0] == null) {
        return $move;
    }
    $finalPathArray=[];
    $symbolPathArray=array_merge(explode('/', $current), $moveArray);
    for ($i = 0; $i < count($symbolPathArray); $i++) {
        $cp=$symbolPathArray[$i];
        if ($cp == "..") {
            unset($finalPathArray[count($finalPathArray)-1]);
            continue;
        } elseif ($cp == '.') {
            continue;
        } elseif ($cp == null) {
            continue;
        }
        $finalPathArray[]=$cp;
    }
    return DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $finalPathArray);
}




function fs_walk($dir)
{
    $fs= new \RecursiveIteratorIterator($dir);

    foreach ($fs as $item) {
        print_r($item->getPath().PHP_EOL);
    }
}
