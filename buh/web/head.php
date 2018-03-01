<?php
namespace main\web;
// require 'web_construct_base.php';
$title_line="Простая бухгалтерия. Веб редакция";

$title = new tag_double("title",[],[$title_line]);
$charset="utf-8";
$meta_charset= new tag_simple("meta",["charset"=>$charset]);

$head= new tag_double("head",[],[$title,$meta_charset]);

// echo $head->getHtml();
 ?>
