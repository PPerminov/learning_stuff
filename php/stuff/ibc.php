<?php


class slaveRent
{
    private $slave;
    private $slaveStubDb=[['id'=>0,'name'=>'Jhon','sex'=>'male','age'=>17,'weight'=>42,'skin'=>'white','place'=>'Winterfell','description'=>'Thinks that he is Stark','rent'=>21,'price'=>80000,'cathegoryId'=>[1,2]],[ 'id'=>1,'name'=>'Cersei','sex'=>'female','age'=>46,'weight'=>51,'skin'=>'white','place'=>'Casterly rock','description'=>'Thinks that she is klever','rent'=>12,'price'=>40000,'cathegoryId'=>[2,7]]];
    private $orderInfo=[];

    public function __construct($id)
    {
        $this->slave = $this->getSlaveData($id);
        $this->getAdditionalInfo();
        $this->print();
    }
    private function getReservedTimeIn($id, $type=0)
    {
        $data = $this->timeReserved[$id];
        switch ($type) {
          case 'durationSum':
            $sum = 0;
            foreach ($data as $line) {
                $sum+=$line['duration'];
            }
            return $sum;
            break;
          case 'reservedAsStrings':
            $strings='';
            foreach ($data as $line) {
                $reservedTime = new DateTime($line['begin']);
                $reserveBeginTime = $timeClass->format('Y-m-d');
            }
            return $strings;
            break;
          default:
            return $data;
          break;
      }
    }
    private function out($something)
    {
        print_r($something);
    }
    private function getSlaveData($id)
    {
        return $this->slaveStubDb[$id];
    }
    private function getAdditionalInfo()
    {
        $slaveId = $this->slave['id'];

        $currentReservedTime = getReservedTimeIn($slaveId);
    }
    private function print()
    {
        $lines=[];
        if ($this->slave['sex'] == 'male') {
            $lines[0] = 'Вы приобрели раба ' . $this->slave['name'];
        } else {
            $lines[0] = 'Вы приобрели рабыню ' . $this->slave['name'];
        }
        $lines[1]='на ';
        $iterator = function ($lineNumber) {
        };
    }
}
