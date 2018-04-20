<?php
namespace Perminov\Engine;

require_once 'Unit.php';
require_once 'Master.php';
require_once 'Slave.php';
require_once 'DataBase.php';
require_once 'General.php';

use Perminov\DataBase\DataBase;
use Perminov\Slave\Slave;
use Perminov\Master\Master;

class Market
{
    private $masters;
    private $slaves;
    private $reservations;
    private $workTypes;
    private $dbClass;
    private $db;

    public function __construct($db)
    {
        $this->dbClass = $db;
        $this->db = $this->dbClass->getConnector();
        $this->getAllWorkTypes();
    }
    // private function getAllWorkTypes()
    // {
    //     $types = $this->db->query('select * from workTypes');
    //     foreach ($types as $type) {
    //         $this->workTypes[] = $type;
    //     }
    //     $sorter = function ($x, $y) {
    //         if ($x['id'] > $y['id']) {
    //             return 1;
    //         } elseif ($x['id'] < $y['id']) {
    //             return -1;
    //         } else {
    //             return 0;
    //         }
    //     };
    //     usort($this->workTypes, $orter);
    // }
    private function getAllWorkTypes(){
      $types = $this->db->query('select * from workTypes');
    }

    public function getAllMasters()
    {
        $masters = $this->db->query('select * from masters;')->FetchAll();
        foreach ($masters as $master) {
            $this->masters[] = new Master($master);
        }
    }
    public function getAllSlaves()
    {
        $slaves = $this->db->query('select * from slaves;')->FetchAll();
        foreach ($slaves as $slave) {
            $this->slaves[] = new Slave($slave);
        }
    }
    public function getAllSlavesReservation()
    {
        $currenttime = time();
        $query = 'select * from resevations where endtime > ' . $currentTime . ' and starttime < '. $currentTime .';';
        $this->reservations = $this->db->query($query)->FetchAll();
    }
    private function checkSlaveReservation($startTime, $endTime, $slave)
    {
        if ($endTime <= $starttime) {
            throw new Exception;
        }
        $query = 'select count(*) from reservations where (' . $endTime . ' not between starttime and endtime) and (' . $startTime . ' not between starttime and endtime) and slaveid = ' . $slave->getId() . ';';
        $reservations = $this->db->query($query);
        if ($query != 0) {
            throw new Exception;
            return false;
        }
        return true;
    }

    private function countDays($startTime, $endTime)
    {
        $delta = $endTime - $startTime;
        $beginOfStartDay = strtotime("midnight", $startTime);
        $beginOfEndDay = strtotime("midnight", $endTime);

        if ($beginOfStartDay == $beginOfEndDay) {
            if ($delta > 16) {
                $days = 1;
                $hours = 0;
            } else {
                $days = 0;
                $hours = $delta;
            }
        } else {
            $days = $delta / 86400;
            $hours = $delta % 86400;
        }
        return [$days,$hours];
    }

    public function getWorkTypesTree()
    {
        $this->tree=[];
        foreach ($this->workTypes as $leave) {
            $this->tree[$leave['pid']][]=$leave;
        }

    }
    public function recruit($master, $slave, $startTime, $endTime)
    {
        if (!$this->checkSlaveReservation($startTime, $endTime, $slave)) {
            return 'Unpossible';
        }
        $masterMoney = $master->money + ($master->sheeps * $this->sheepExchangeRate);
        $slavePrice = $slave->getPrice();
        $rentTime = $this->countDays($startTime, $endTime);
        $rentPrice = ($rentTime[0] * $slaveprice * 16) + ($rentTime * $slavePrice);
        if ($rentPrice < $masterMoney) {
            return 'Not enough money';
        }
        $masterId = $master->id;
    }
}


$stat = new Market(new DataBase('test.db'));
