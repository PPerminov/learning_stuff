<?php
/*Full path*/
echo __FILE__ . PHP_EOL;
/*Full dir*/
echo __DIR__ . PHP_EOL;
/*Full file name*/
echo basename(__FILE__) . PHP_EOL;
/*info*/
print_r(pathinfo(__FILE__));
echo PHP_EOL;
/*Current dir*/
echo getcwd(). PHP_EOL;
/*build path*/
$path=['vat','het'];
echo DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR,$path);
/*SPLfileinfo*/
$thi=new \SPLfileinfo(__FILE__);
print_r(get_class_methods($thi));
