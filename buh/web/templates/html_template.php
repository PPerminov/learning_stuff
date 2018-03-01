<?php
namespace main\db;
require '../../db/database.php';
$db=new db("localhost", "buh_test", db_user, db_pass, db_array);
$data="insert into Html (name,html) values ('base','<html>\n<head>\n<title></title>\n</head>\n<body>\n</body>\n</html>')";
$db->dbo->exec($data);
$t=$db->dbo->query('select * from Html');
$data=$t->fetchAll();
echo $data[7]['id'];
// print_r($data);
