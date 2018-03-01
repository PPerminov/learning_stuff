<?php
class php_test
{
    private $res=[];
    private $res1=[];
    private $res2=[];
    private $res3=[];

    public function __construct()
    {
        for ($i=0;$i<1000000;$i++) {
            $this->res[]=rand(100000, 1500000);
        }
    }
    public function test1()
    {
        echo "Started test 1\n";
        for ($i=0;$i<count($this->res);$i++) {
            if ($i%1000 == 0) {
                echo $i . "Line\n";
            }
            if (in_array($this->res[$i], $this->res1)) {
                continue;
            } elseif (in_array($this->res[$i], $this->res2)) {
                $this->res1[]=$this->res[$i];
            } else {
                $this->res2[]=$this->res[$i];
            }
        }
        return $this->res1;
    }
    public function test2()
    {
        $this->res1=[];
        $value=null;
        $value2=null;
        for ($i=0;$i<count($this->res);$i++) {
            if ($this->res[$i]==$value && $this->res[$i]==$value2) {
                continue;
            } elseif ($this->res[$i] == $value) {
                $value2=$this->res[$i];
                $this->res1[]=$this->res[$i];
                continue;
            } elseif ($this->res[$i]!=$value) {
                $value=$this->res[$i];
                $value2=null;
            }
        }
        return $this->res1;
    }

    public function res_sort()
    {
        $this->res3=$this->res;
        sort($this->res);
        // $this->res=$this->res3;
        //print_r($this->res);
    }

    public function serial($fname)
    {
        $file=fopen($fname, 'w+');
        fwrite($file, serialize($this));
        fclose($file);
    }

    public function unserial($fname)
    {
        $file=fopen($fname, 'r');
        $data=unserialize(fread($file, filesize($fname)));
        fclose($file);
        return $data;
    }

    public function get_res($res=0)
    {
        if ($res == 1) {
            return $this->res1;
        } elseif ($res == 2) {
            return $this->res2;
        } elseif ($res == 0) {
            return $this->res;
        } else {
            return false;
        }
    }
}


// $test1=new php_test;

// $test1->test1();
// $test1->serial('file1.txt');
//$test1->res_sort();
// $test1->test1();
// $test1->serial('file2.txt');
// $data=php_test::unserial('file1.txt');
$data=new php_test;

// echo count($data->test1()) . "\n";
echo count($data->get_res());
echo microtime() . "\n";
$data->res_sort();
echo count($data1=$data->test2());
echo microtime() . "\n";
