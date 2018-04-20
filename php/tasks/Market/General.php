<?php
namespace Perminov\General;

function pair($a, $b=null)
{
    return function ($method) use ($a,$b) {
        if ($method == 'car') {
            return $a;
        } elseif ($method == 'cdr') {
            return $b;
        } else {
            return null;
        }
    };
}

function car($cons)
{
    return $cons('car');
}

function cdr($cons)
{
    return $cons('cdr');
}

function l(...$data)
{
    $lister=function ($accum, $data) {
        return pair($data, $accum);
    };
    return array_reduce(array_reverse($data), $lister, null);
}

function head($list)
{
    return car($list);
}

function tail($list)
{
    return cdr($list);
}

function isEmpty($list)
{
    if ($list == null) {
        return true;
    }
    return false;
}

// function toString($list, $accum='(')
// {
//     if (isEmpty($list)) {
//         return ')';
//     }
//     return toString(tail($list), $accum);
// }

function ladd($list, $data, $position=0)
{
    if (isEmpty($list)) {
        return null;
    }
    if ($position == 0) {
        return pair($data, pair(head($list), ladd(tail($list), $data, $position - 1)));
    }
    return pair(head($list), ladd(tail($list), $data, $position-1));
}

function isList($list)
{
    if (!is_callable($list)) {
        return false;
    }
    if (car($list) && cdr($list)) {
        return true;
    }
    return false;
}

function toTree($list, $deepness=0,$accum='')
{
    if (isempty($list)) {
        return $accum;
    }
    $currentDeepness=function () use ($deepness) {
        $symbol = '';
        while ($deepness >= 0) {
            $symbol .= '--';
            $deepness--;
        }
        return $symbol;
    };
    $currentLine = head($list);
    if (isList($currentLine)) {
        $accum.=toTree($currentLine, $deepness+1);
    } else {
        $accum.=$currentString = $currentDeepness() . $currentLine . PHP_EOL;
    }
    return toTree(tail($list), $deepness,$accum);
}
