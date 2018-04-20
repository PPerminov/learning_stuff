<?php
namespace Perminov\Master;

use \Perminov\Unit\Unit;

class Master extends Unit
{
    private $id;
    private $name;
    private $money;
    private $sheeps;
    private $currentSlaves=[];

    public function __construct($sqlArray)
    {
        $this->id = $sqlArray['id'];
        $this->name = $sqlArray['name'];
        $this->money = $sqlArray['money'];
        $this->sheeps = $sqlArray['sheeps'];
    }
    public function getCurrentSlaves($db)
    {
        $reservations = $db->getSlavesReservation();
        foreach ($reservations as $reservation) {
            if ($reservation['masterId'] == $this->id) {
                $this->currentSlaves[]=$reservation['slaveId'];
            }
        }
    }
}
