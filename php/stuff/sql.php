<?php

function tree($elements)
{
    return function (callable $function) use (&$elements) {
        return $function($elements);
    };
}

function get_tree_position($tree, $position, $parent=0)
{
    $iter=function ($tree) use (&$position, &$counter, &$iter) {
        foreach ($tree as $pos) {
            if (is_array($pos)) {
                $remp=$iter($pos);
                if ($remp === null) {
                    continue;
                } else {
                    return $remp;
                }
            } elseif ($counter == $position) {
                return $pos;
            } else {
                $counter++;
            }
        }
        return null;
    };
    return $tree($iter);
};

//TODO
//Recollect lalabet as different arrays for diffetent str_types
//and merge them when needed

function generate_string($lenght=3, $type=null)
{
    $lalabet=['a','b','c','d','e','f','g','h','i','j','k',
  'l','m','n','o','p','q','r','s','t','u','v','w','x',
  'y','z','A','B','C','D','E','F','G','H','I','J','K',
  'L','M','N','O','P','Q','R','S','T','U','V','W','X',
  'Y','Z',0,1,2,3,4,5,6,7,8,9,'~','`','@','#','$','%',
  '^','&','*','(',')','_','-','+','=',',','.','/','<',
  '>','?',';','\'',':','"','{','}','[',']','\\','|'];
    $lalabet_rus_up=['А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й',
    'К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х',
    'Ц','Ч','Ш','Щ','Ъ','Ь','Ы','Э','Ю','Я'];
    $lalabet_rus_low=['а','б','в','г','д','е','ё','ж',
    'з','и','й','к','л','м','н','о','п','р','с','т',
    'у','ф','х','ц','ч','ш','щ','ъ','ь','ы','э','ю',
    'я'];
    $top=count($lalabet)-1;
    $lower=[0,25];
    $upper=[26,51];
    $nums=[52,61];
    $symbols=[62,$top];
    $string='';
    if ($type=='lotext') {
        $begin=$lower[0];
        $end=$lower[1];
    } elseif ($type=='uptext') {
        $begin=$upper[0];
        $end=$upper[1];
    } elseif ($type=='text') {
        $begin=$lower[0];
        $end=$upper[1];
    } elseif ($type=='number') {
        $begin=$nums[0];
        $end=$nums[1];
    } elseif ($type=='text_num') {
        $begin=$lower[0];
        $end=$nums[1];
    } elseif ($type=='symbols') {
        $begin=$symbols[0];
        $end=$symbols[1];
    } else {
        $begin=0;
        $end=$top;
    }
    for ($i=0;$i<$lenght;$i++) {
        $string.=$lalabet[rand($begin, $end)];
    }
    return $string;
}

function gen_leveled_array($levels, $deep=5)
{
    $result=[];

    foreach (range(0, rand(0, $levels - 1)) as $level) {
        if (rand(1, 2)%2 == 0 && $deep !=0) {
            $result[]=gen_leveled_array(5, $deep-1);
        } else {
            $result[]=generate_string(3, 'text');
        }
    }
    return $result;
}

function tree_to_sql($tree, $pdo)
{
    $array_name=[];
    $array_parent=[];
    $counter=0;
    $iter=function ($tree, $parent_id=null, $pold=null) use (&$counter, &$iter, &$array_name, &$array_parent) {
        foreach ($tree as $item) {
            if (is_array($item)) {
                $iter($item, $counter, $parent_id);
            } else {
                if ($counter == $parent_id) {
                    $array_parent[$counter]=$pold;
                } else {
                    $array_parent[$counter]=$parent_id;
                }
                $array_name[$counter]=$item;
                $counter++;
            }
        }
    };
    $iter($tree);

    if (count($array_name) !=  count($array_parent)) {
        return \Exception;
    }

    $pdo->beginTransaction();

    // $sql="";
    for ($position=0;$position < count($array_name);$position++) {
        // $sql.="insert into table values (" . $position . "," .$array_name[$position] . "," . $array_parent[$position] . ");\n";
          if ($array_parent[$position] == null) {
              $sql="insert into t1 (id,name,pid) values (" . $position . ",'" .$array_name[$position] . "',null)";
          } else {
              $sql="insert into t1 (id,name,pid) values (" . $position . ",'" .$array_name[$position] . "'," . $array_parent[$position] . ")";
          }
        echo $sql . "\n";
        $pdo->exec($sql);
      // "For id=" . $position . " named " . $array_name[$position] . " parent id is" . $array_parent[$position] . "\n";
    }
    return $pdo->commit();

    //return $pdo->fetchAll();
}

function sql_to_tree($pdo)
{
    $array_name=[];
    $array_parent=[];
    $motherar=[];
    $tmp_array=[];
    $data=$pdo->query('select * from t1');
$placement=function(array $data) use (&$placement,&$motherar,&$tmp_array){

};
    foreach ($data->fetchAll() as $line) {
        $array_name[]=$line['name'];
        $array_parent[]=$line['pid'];
    }

    for ($pos=0;$pos<count($array_parent);$pos++) {
        if ($array_parent[$pos]==null) {
            $motherar[]=$array_name[$pos];
        } elseif (in_array($array_parent[$pos], $motherar)) {

        }
    }



    return $motherar;
    // print_r($array_parent);
    // print_r($array_name);
}



//
//
//
// $pdo=new \PDO('sqlite:nano.db', null, null, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC]);
// $pdo->exec('create table if not exists t1 (id INT,name TEXT,pid INT)');
// $tree=tree(['ee','eb',['ac','gf',['rt','tr','uy','za'],'ff',['yt','op',45]],'ec','kc',['mh',['rt','ui']]]);
$tree1=['ee','eb',['ac','gf',['rt','tr','uy','za'],'ff',['yt','op',45]],'ec','kc',['mh',['rt','ui']]];
// // print_r(gen_leveled_array(16));
// // print_r(tree_to_sql($tree1, $pdo));
// print_r(sql_to_tree($pdo));


$else=print_r($tree1);

echo $else;
