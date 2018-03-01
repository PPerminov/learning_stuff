<?php

if (isset($_POST['name'])) {

    $first=[' ','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я'];
    $second=[' ','A','B','V','G','D','E','E','Zh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','Kh','Ts','Ch','Sh','Shch','','Y','','E','Yu','Ya','a','b','v','g','d','e','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','kh','ts','ch','sh','shch','','y','','e','yu','ya'];
    $text=$_POST['name'];

    function mb_str_split($str)
    {
        preg_match_all('#.{1}#uis', $str, $out);
        return $out[0];
    }

    $ar=mb_str_split($text);
    $new_line="";
    foreach ($ar as $l) {
        if (in_array($l, $first)) {
            $new_line.=$second[array_search($l, $first)];
        }
    }
}

  include 'tmp.html';
