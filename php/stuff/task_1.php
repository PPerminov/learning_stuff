<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class task
{
    private $pdo;
    public $tree;
    private $tmp_id=1;
    private $index=[];

//$tree=['id'=>$id,$name,$parentid]


    public function __construct($pdo, $recreate=0)
    {
        $this->pdo=$pdo;
        if ($recreate != 0) {
            $this->table('recreate');
        }
    }

    public function table($todo=null)
    {
        if ($todo === 'recreate') {
            $this->pdo->exec('drop table if exists t1');
            $this->pdo->exec('create table if not exists t1 (id INT,name TEXT,pid INT)');
        } elseif ($todo== 'create') {
            $this->pdo->exec('create table if not exists t1 (id INT,name TEXT,pid INT)');
        } elseif ($todo == 'test_query') {
            return $this->pdo->query('select * from t1')->fetchAll();
        }
    }

    public function generate_string($lenght=3, ...$types)
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

    public function setup_tree($levels, $deep=5, $pid=0)
    {
        foreach (range(0, rand(0, $levels - 1)) as $level) {
            $parent_id=$this->tmp_id;
            $this->tree[]=['id'=>$this->tmp_id,'name'=>$this->generate_string(3, 'en_low'),'pid'=>$pid];
            $this->tmp_id++;
            if (rand(1, 2) == 2 && $deep !=0) {
                $this->setup_tree($levels, $deep-1, $parent_id);
            }
        }
        $this->create_index();
    }

    private function tree_to_array()
    {
        $result=[];

        foreach ($this->tree as $branch) {
        }
        return $result;
    }

    public function tree_to_sql()
    {
        $working_set=$this->pdo->prepare('insert into t1 values(?,?,?);');

        foreach ($this->tree as $unit) {
            $working_set->execute([$unit['id'], $unit['name'], $unit['pid']]);
        }
    }

    private function create_index()
    {
        $global_position=0;
        foreach ($this->tree as $branch) {
            $this->index[$branch['id']]=$global_position;
            $global_position++;
        }
    }

    private function find_parent(array $item)
    {
        if ($item['pid']==0  or (! in_array($item, $this->tree))) {
            return null;
        }
        return $this->tree[$this->index[$item['pid']]];
    }



    public function find_deepness(array $item, $deepness=0)
    {
        if ($item['pid'] == 0) {
            return $deepness;
        }

        return $this->find_deepness($this->find_parent($item), $deepness+1);
    }

    public function sql_to_tree()
    {
        $this->tree=$this->pdo->query('select * from t1')->fetchAll();
    }


    private function build_full_branch($item)
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

    public function draw()
    {
        $dataToReturn=[];
        $mention=[];
        foreach (array_reverse($this->tree) as $item) {
            $tmp_result=$this->build_full_branch($item);
            foreach ($tmp_result as $tmp_item) {
                if (!in_array($tmp_item, $mention)) {
                    $mention[]=$tmp_item;
                }
            }
            $dataToReturn[]=$tmp_result;
        }
        return $mention;
    }
}

//$pdo=new \PDO('sqlite::memory:', null, null, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC]);
















//
