<?php
require 'task_2.php';
// echo "<pre>";
// print_r(parse_tags($input_for_task1));
$t=$_GET['task'];
switch ($t) {
case 'task1':
// echo "Задание 1\n";
include 'n/task1.tmpl';
break;
case 'task2':
include 'n/task2.tmpl';
break;
case 'task3':
include 'n/task3.tmpl';
break;
case 'task6':
include 'n/task6.tmpl';
break;
case 'task7':
// echo "Задание 7<br><pre>";
include 'n/task7.tmpl';
break;
}
