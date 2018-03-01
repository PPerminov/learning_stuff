<?php
namespace stuff;
require 'brackets.php';
use \PHPUnit_Framework_TestCase;




class bracketsTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @dataProvider dataProv
    */
    public function testBrackets($expect,$bracketSet)
    {
        $this->assertEquals($expect,brackets($bracketSet));
    }

    public function dataProv() {
      return [['YES','{}[]()'],['YES','{[()]()}'],['NO','{[(]})']];
    }

}
