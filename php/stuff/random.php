<?php
function find_solution($counter = 0)
{
    $randA = rand(1, 5464);
    $randB = rand(1, 5464);
    $randC = rand(1, 5464);
    if ($randA * $randB == $randC) {
        return $counter;
    }
    return find_solution($counter++);
}

$array=[];
while (count($array) <= 50) {
    $array[]=find_solution();
}
