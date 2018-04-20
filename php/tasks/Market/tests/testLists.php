<?php
namespace Perminov\General;

require_once 'General.php';
require_once 'General_side-effects.php';
// use Perminov\General\l;
// use Perminov\General\pair;

class ListsTests extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->list=l(1, 2, 3, 4, 5, 6, 7, 8, 9);
    }
    public function tearDown(){
      $this->list=null;
    }
    public function testListEqualPairs()
    {
      $this->assertEquals($this->list,pair(1,pair(2,pair(3,pair(4,pair(5,pair(6,pair(7,pair(8,pair(9,null))))))))));
    }
    public function testListHead(){
      $this->assertEquals(head($this->list),1);
    }
    public function testListTail(){
      $this->assertEquals(tail($this->list),pair(2,pair(3,pair(4,pair(5,pair(6,pair(7,pair(8,pair(9,null)))))))));
    }

    public function testAddToListFirstPosition(){
      $this->assertEquals(ladd($this->list,666),pair(666,pair(1,pair(2,pair(3,pair(4,pair(5,pair(6,pair(7,pair(8,pair(9,null)))))))))));
    }

    public function testAddToListthirdPosition(){
      $this->assertEquals(ladd($this->list,666,3),pair(1,pair(2,pair(3,pair(666,pair(4,pair(5,pair(6,pair(7,pair(8,pair(9,null)))))))))));
    }
    public function testListemptyness(){
      $test_object = l();
      $this->assertTrue(isempty($test_object));
    }
    
}
