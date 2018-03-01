<?php
namespace main\web;


function parse_tags($html){
   preg_match_all('/<\/(.*?)>|<(.*?)>|\>(.*?)\</',$html,$comp);
   return $comp;
}

function convert_template($string){
$array=parse_tags($string);
print_r($array);
}
//
$file=fopen('templates/headers.tmpl','r');
$data=fread($file,filesize('templates/headers.tmpl'));
convert_template($data);




function topMenuBuider()
{
    $topMenu= new tag_double("table", ['width'=>'100%'], [new tag_double('tr', [], [
new tag_double("th", [], [
  new tag_double('a', ['href'=>"/index.php?page=account"], ["Счета"])
]),
new tag_double("th", [], [
  new tag_double('a', ['href'=>"/index.php?page=income"], ["Приход"])
]),
new tag_double("th", [], [
  new tag_double('a', ['href'=>"/index.php?page=spend"], ["Расход"])
]),
new tag_double("th", [], [
  new tag_double('a', ['href'=>"/index.php?page=db"], ["Обслуживание БД"])
])
  ])]);
    return $topMenu->getHtml();
}

function accountBuilder()
{
    return "Цэ страница считов";
}
function incomeBuilder()
{
    return "Цэ страница приходов";
}

function spendBuilder()
{
    return "Цэ страница расходов";
}

function db()
{
    return "Цэ страница быды";
}

//
// <div id=topMenu></div>
//



// $menu=new tag_double();
//
//
// foreach ($topMenu as $code => $name) {
//   $link="index.php?page=" . $code;
//   $topMenuLinksArray[]=new tag_double('a',['href'=>$link],[$name]);
// }
//
// //<table><tr><th></th></tr></table>
//
// foreach ($topMenuLinksArray as $point){
//
// }
//
//
//
// $topMenuTableRowOne = new tag_double("th",[],[]);
// $topMenuTableRowOne = new tag_double("tr",[],[]);
// $topMenuTable=new tag_double("table",[],[]);
