<?php
namespace Perminov\DataBase;

class DataBase
{
    private $connector;
    private $connString;
    private $sqlFile;

    public function __construct($dbfile = false)
    {
        if ($dbfile) {
            $this->sqlFile = $dbfile;
            $this->connString = 'sqlite:'.$this->sqlFile;
        } else {
            $this->connString = 'sqlite::memory:';
        }
        $this->connector = new \PDO($this->connString, null, null, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC]);
    }

    public function createTables($recreate = false)
    {
        if ($recreate) {
            $dropTablesArray=[
                      'drop table slaves;',
                      'drop table workTypes;',
                      'drop table slavesWork;',
                      'drop table skins;',
                      'drop table reservations;'
                              ];
            foreach ($dropTablesArray as $value => $key) {
                $this->connector->exec($key);
            }
        }
        $tablesArray = [
                       'create table if not exists masters (id int, name varchar(255) unique, vip bool);',
                       'create table if not exists slaves (id int, name varchar(255) unique, sex smallint, age smallint, weight smallint, skin smallint, origin varchar(255), comment text, price int);',
                       'create table if not exists workTypes (id int ,name varchar(255) unique,pid int);',
                       'create table if not exists slavesWork (slaveId int not null, workId int not null, unique ( slaveId, workId) on conflict ignore );',
                       'create table if not exists skins (id smalint, name varchar(10) unique);',
                       'create table if not exists reservations (slaveId int, starttime int, endtime int, masterId, unique(slaveid, starttime,endtime));'
                       ];
        foreach ($tablesArray as $value => $key) {
            $this->connector->exec($key);
        }
    }
    public function prepare($query){
      return $this->connector->prepare($query);
    }
    public function query($query)
    {
        return $this->connector->query($query);
    }
    public function getReservations(){

    }
    public function setReservation($slaveId,$startTime,$endTime,$master){

    }
}
