<?php
function parse_tags($input)
{
    $result['array1']=[];
    $result['array2']=[];
    $data=preg_split('/\[\/\w*\][\n]?/', $input);
    $check=function ($data, $offset) {
        if (count($data) -1 < $offset) {
            return null;
        } else {
            return $data[$offset];
        }
    };
    foreach ($data as $line) {
        if ($line == null) {
            continue;
        }
        $m=[];
        preg_match('/(?!\[)([\w\d\s]*?)(\:|])(?!\:.*)/', $line, $m);
        $tag=$m[1];
        preg_match('/\:(.*)\]/', $line, $m);
        $desc=$check($m, 1);
        preg_match('/\](.*)/', $line, $m);
        $dat=$m[1];

        $result['array1'][]=[$tag=>$desc];
        $result['array2'][]=[$tag=>$dat];
    }


    return $result;
}



/* TASK 2 */
$input_for_task2="raz:rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrdva:ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddtri:ttttttttttttttttttttttttttttttttttttttttttttttttttttttttttdva:wetwer6547y53hyu534";

function parse_raz($input)
{
    $m=[];
    $result=[];
    preg_match_all('/(raz\:)(.*?)(raz\:|dva:|tri:|$)/', $input, $m[]);
    preg_match_all('/(dva\:)(.*?)(raz\:|dva:|tri:|$)/', $input, $m[]);
    preg_match_all('/(tri\:)(.*?)(raz\:|dva:|tri:|$)/', $input, $m[]);
    foreach ($m as $unit) {
        $result[]=[trim($unit[1][0], ':')=>end($unit[2])];
    }
    return $result;
}

/*TASK 3,4,5*/
class task
{
    public $pdo;
    public $tree;
    private $tmp_id=1;
    private $index=[];





    public function __construct($pdo, $recreate=0)
    {
        $this->pdo=$pdo;
        if ($recreate != 0) {
            $this->table('recreate');
            $this->setup_tree(10);
            $this->tree_to_sql();
        // $this->draw();
        } else {
            $this->sql_to_tree();
            $this->create_index();
        }
    }

    private function table($todo=null) //table operations
    {
        if ($todo === 'recreate') { //recreate
            $this->pdo->exec('drop table if exists t1');
            $this->pdo->exec('create table if not exists t1 (id INT,name TEXT,pid INT)');
        } elseif ($todo== 'create') { //create
            $this->pdo->exec('create table if not exists t1 (id INT,name TEXT,pid INT)');
        } elseif ($todo == 'test_query') { //query for test
            return $this->pdo->query('select * from t1')->fetchAll();
        }
    }

    private function generate_string($lenght=3, ...$types)   /*generating strings with selected length and types. Types can be only :
en_low    English lower
en_hi     ........upper
ru_low    Russian lower
ru_hi     ........upper
nums      Numbers
sym       Symbols
    */
    {
        $en_low=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $en_hi=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $nums=[0,1,2,3,4,5,6,7,8,9];
        $sym=['~','`','@','#','$','%','^','&','*','(',')','_','-','+','=',',','.','/','<','>','?',';','\'',':','"','{','}','[',']','\\','|'];
        $ru_hi=['А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ы','Э','Ю','Я'];
        $ru_low=['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ь','ы','э','ю','я'];
        $string='';
        $lalabet=[];
        foreach ($types as $type) {
            $lalabet=array_merge($lalabet, $$type);
        }
        for ($i=0;$i<$lenght;$i++) {
            $string.=$lalabet[rand(0, count($lalabet)-1)];
        }
        return $string;
    }
    public function setup_tree($levels, $deep=5, $pid=0, $max=0) /* Makes a tree with selected maximum sublevels in one level and maximum deepness from zero level*/
    {
        if ($max != 0) {
            foreach (range(0, $levels - 1) as $level) {
                $parent_id=$this->tmp_id;
                $this->tree[]=['id'=>$this->tmp_id,'name'=>$this->generate_string(3, 'en_low'),'pid'=>$pid];
                $this->tmp_id++;
                if ($deep !=0) {
                    $this->setup_tree($levels, $deep-1, $parent_id, $max);
                }
            }
        } else {
            foreach (range(0, rand(0, $levels - 1)) as $level) {
                $parent_id=$this->tmp_id;
                $this->tree[]=['id'=>$this->tmp_id,'name'=>$this->generate_string(3, 'en_low'),'pid'=>$pid];
                $this->tmp_id++;
                if (rand(1, 2) == 2 && $deep !=0) {
                    $this->setup_tree($levels, $deep-1, $parent_id);
                }
            }
        }
        $this->create_index();
    }


    public function tree_to_sql() /*  inserts data to sql database  */
    {
        $working_set=$this->pdo->prepare('insert into t1 values(?,?,?);');

        foreach ($this->tree as $unit) {
            $working_set->execute([$unit['id'], $unit['name'], $unit['pid']]);
        }
    }

    private function create_index() /*  creates index of id's positions   */
    {
        $global_position=0;
        foreach ($this->tree as $branch) {
            $this->index[$branch['id']]=$global_position;
            $global_position++;
        }
    }

    private function find_parent(array $item) /*this function can find parent of a leave*/
    {
        if ($item['pid']==0  or (! in_array($item, $this->tree))) {
            return null;
        }
        return $this->tree[$this->index[$item['pid']]];
    }



    private function find_deepness(array $item, $deepness=0) /*this function can find deepness of pointed leave */
    {
        if ($item['pid'] == 0) {
            return $deepness;
        }

        return $this->find_deepness($this->find_parent($item), $deepness+1);
    }

    private function sql_to_tree() /*this function get data from sql table*/
    {
        $this->tree=$this->pdo->query('select * from t1')->fetchAll();
    }


    private function build_full_branch($item) /*this function return array with full path to leave*/
    {
        $result=[];

        $iter=function ($item) use (&$iter, &$result) {
            $result[]=$item['id'];
            if ($item['pid'] != 0) {
                $iter($this->find_parent($item));
            }
        };

        $iter($item);

        return array_reverse($result);
    }


    public function draw() /*this function draw an output*/
    {
        $blank="   ";
        $line="";

        foreach ($this->tree as $leave) {
            for ($f=0;$f<$this->find_deepness($leave);$f++) {
                $line.=$blank;
            }
            $line.="---".$leave['name']."\n";
            echo $line;
            $line="";
        }
    }

    public function get_sql($type=null) /*this function gets leaves with two parents or leaves with more than three childs*/
    {
        $micro1=microtime(true);


        $this->pdo->query('select tt.id,tt.name,tt.pid from t1 as tt join t1 as tp on tt.pid = tp.id join t1 as ty on tp.pid = ty.id where ty.pid = 0');
        $micro2=microtime(true);
        $this->pdo->query('select id,name,pid as pid_orig from t1 where pid_orig in (select id from t1 where pid in (select id from t1 where pid is 0))');
        $micro3=microtime(true);

        $first=$micro2 - $micro1;
        $second=$micro3 - $micro2;
        $per=$first / 100.0;


        echo "First:  " . $first . "\n";
        echo "Second: " . $second . "\n";

        echo "Total:  " . $second / $per . '%';
    }
}



/*TEST TASK 6*/

function arrays_generator()
{
    $result=[];
    for ($pos=0;$pos<1000000;$pos++) {
        $result[]=rand(100000, 1500000);
    }
    return $result;
}


/*I don't sure that this method is the best. But it really faster than others I have tried. And it makes less operations*/

function arrays_duplicate_finder($input)
{
    sort($input);
    $tmp1=0;
    $tmp2=0;
    $result=[];

    for ($i=0;$i<count($input);$i++) {
        if ($input[$i] == $tmp1 and $input[$i] == $tmp2) {
            continue;
        } elseif ($input[$i] == $tmp1 and $input[$i] != $tmp2) {
            $tmp2 =$input[$i];
            $result[]=$input[$i];
            continue;
        } else {
            $tmp2=0;
            $tmp1=$input[$i];
        }
    }
    return $result;
}



/*TEST TASK 7*/


function count_faces($faces) /*JUST FOR FUN it counts possible variations*/
{
    $accum=1;
    foreach ($faces as $face) {
        $accum*=count($face);
    }

    $factor=function ($num, $acc) use (&$factor) {
        if ($num == 0) {
            return $acc;
        }

        return $factor($num-1, $acc*$num);
    };
    return $accum;
}



function how_many_faces($faces)
{
    $result=[];
    $tmp1=[];
    $iter=function ($level=0) use (&$iter, &$result, &$faces, &$tmp1) {
        foreach ($faces[$level] as $cur) {
            if ($level == 0) {
                $tmp1=[];
            }
            $tmp1[$level]=$cur;
            if ($level < count($faces)-1) {
                $iter($level+1);
            } else {
                $result[]=$tmp1;
                continue;
            }
        }
    };
    $iter(0);
    return $result;
}

function convert_input_array($input)
{
    $result=[];
    $check=function ($inter) {
        $count=0;

        foreach ($inter as $cool) {
            if ($cool == '[') {
                $count++;
            } elseif ($cool == ']') {
                $count--;
            }
            if ($count > 1) {
                return false;
            }
        }
        return true;
    };

    if (!$check(str_split($input))) {
        return false;
    }
    $data=preg_split('/"|,/', $input);
    $array=0;
    foreach ($data as $k =>$v) {
        if ($v==']') {
            $array++;
            continue;
        } elseif (preg_match('/\w/', $v)) {
            $result[$array][]=$v;
        }
    }

    return $result;
}

$pdo=new \PDO('sqlite:/tmp/db1', null, null, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC]);

$data=new task($pdo, 1);

print_r($data->draw());
