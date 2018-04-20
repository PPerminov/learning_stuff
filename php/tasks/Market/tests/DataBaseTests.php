<?php
require 'DataBase.php';
// require 'Engine.php';


use Perminov\DataBase\Database;

class DataBaseTests extends PHPUnit_Framework_TestCase
{
    private $db;
    public function setUp()
    {
        $workTypes=[
                           [0,'Home'.null],
                           [1,'Kitchen',0],
                           [2,'DishWash',1],
                           [3,'Coocking',1],
                           [4,'Bedroom',1],
                           [5,'Cleaning',4],
                           [6,'Washing',4],
                           [7,'Garden',1],
                           [8,'Watering',7],
                           [9,'Weeding',7],
                           [10,'Field',null],
                           [11,'Harvesting',10],
                           [12,'Gazing',10],
                           [13,'War',null],
                           [14,'Dressing',13],
                           [15,'Sharping',13],
                           [16,'Killing',13]
                       ];
        $skins=[
                       [0,'White'],
                       [1,'Dark']
                   ];
        $slaves=[
                          [0,'John Snow',0,20,60,0,'Winterfell','King',150],
                          [1,'Selena Gomez',1,15,40,0,'USA','Stupid bitch. Look for your dish',20],
                          [2,'Princess Kitana',1,40,50,0,'Edenia','Can kill you',150],
                          [3,'Aleksandr Buinov',0,70,80,0,'USSR','Bambuk',10],
                          [4,'Yokozuna Musashimaru', 0, 40, 235, 1, 'Hawaii','https://www.exler.ru/blog/upload/japan.mp3',140],
                          [5,'Laura Palmer', 1, 16, 45, 0, 'Twin Peaks','Fetish Model',600]
                ];
        $masters = [
                          [0,'David Lynch',false],
                          [1,'Queen Elizabeth I',true]
                   ];
        $slavesWork=[
                            [0,14],[0,15],[0,16],
                            [1,2],[1,5],[1,6],[1,8],[1,9],
                            [2,15],[2,16],
                            [3,11],
                            [4,11],[4,12],[4,16],
                            [5,16],[5,5]
                        ];
        $this->slaves = $slaves;
        $this->db=new DataBase('file.db');
        $this->db->createTables();
        $cursors=['insert or ignore into slaves values (?,?,?,?,?,?,?,?,?)'=>$slaves,
                'insert or ignore into workTypes values (?,?,?)'=>$workTypes,
                'insert or ignore into skins values (?,?)'=>$skins,
                'insert or ignore into slavesWork values (?,?)'=>$slavesWork
               ];

        foreach ($cursors as $key => $value) {
            $this->cursor=$this->db->prepare($key);
            foreach ($value as $nextKey => $dataSet) {
                $this->cursor->execute($dataSet);
            }
        }
    }

    public function tearDown()
    {
        $this->db = null;
    }

    public function testsKuchaNo1()
    {
        $weightData=$this->db->query('select min(price) as min, max(price) as max, avg(price) as average from slaves where weight > 60')->FetchAll();
        $this->assertEquals($weightData[0]['average'], 75.0);

        $totalPrice=$this->db->query('select sum(price) as sum from slaves')->FetchAll();
        $getPriceSum=function ($slaves, $position=0) use (&$getPriceSum) {
            if (!isset($slaves[$position])) {
                return 0;
            }
            return $slaves[$position][8] + $getPriceSum($slaves, $position+1);
        };
        $this->assertEquals($totalPrice[0]['sum'], $getPriceSum($this->slaves));

        $moreThan2=$this->db->query('select name from workTypes where id in (select workid as c from slavesWork group by workid having count(workid) >= 2)')->FetchAll();
        $this->assertEquals(count($moreThan2), 4);

        $mostValued=$this->db->query(
          'select worktypes.name from workTypes join slavesWork sw on workTypes.id=sw.workId join slaves on sw.slaveid=slaves.id group by worktypes.name order by sum(slaves.price) desc limit 1;'
                                               )->FetchAll();
        $this->assertEquals($mostValued[0]['name'], 'Killing');
    }

}
