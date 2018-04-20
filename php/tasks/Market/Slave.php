<?php
namespace Perminov\Slave;

use \Perminov\Unit\Unit;

class Slave extends Unit
{
    private $id;
    private $name;
    private $age;
    private $weight;
    private $place;
    private $comment;
    private $price;
    private $reservation;

    public function __construct($sqlArray)
    {
        $this->id=$sqlArray['id'];
        $this->name=$sqlArray['name'];
        $this->age=$sqlArray['age'];
        $this->weight=$sqlArray['weight'];
        $this->place=$sqlArray['place'];
        $this->comment=$sqlArray['comment'];
        $this->price=$sqlArray['price'];
        // $this->reservation = $this->reservations($this->id);
    }

    // private function getCurrentReservations($db)
    // {
    //     $reservations = $db->getSlavesReservation();
    //     foreach ($reservations as $reservation) {
    //         if ($reservation['slaveid'] == $this->id) {
    //             $this->reservation=$reservation['slaveId'];
    //         }
    //     }
    // }
    public function getPrice() {
      return $this->price;
    }

}
