<?php

function updot($str)
{
    return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1) . '.';
}
function getRandomSomething($something)
{
    $length = sizeof($something) - 1;
    return $something[mt_rand(0, $length)];
};
function sentenceGen($dict)
{
    $slen = mt_rand(5, 8);
    $out=[];
    while ($slen > 0) {
        $out[]=getRandomSomething($dict);
        $slen--;
    }
    return updot(implode(' ', $out));
}

function textGen($dict, $sCount)
{
    $out = [];
    while ($sCount > 0) {
        $out[]=sentenceGen($dict);
        $sCount--;
    }
    return implode(' ', $out);
}

function mainGenerator($db,$dicts,$headers,$count=10000)
{
    $authors = $db->query('select * from authors;')->fetchAll();
    $languages=$db->query('select * from Languages;')->fetchAll();
    $prepared=$db->prepare('insert into Posts (langId, authorId, date,header, body, likes)
                            values (?,?,?,?,?,?)');
    while ($count > 0) {
        $language=$languages[mt_rand(0, sizeOf($languages)-1)]['id'];
        $author=$authors[mt_rand(0, sizeOf($authors)-1)]['id'];
        $text=textGen($dicts[$language-1], mt_rand(3, 4));
        $header=textGen($headers[$language-1], 1);
        $date=gmdate("d-m-Y", mt_rand(1483228800, 1502236799));
        $likes=mt_rand(0, 100);
        $prepared->execute([$language,$author,$date,$header,$text,$likes]);
        $count--;
    }
}
