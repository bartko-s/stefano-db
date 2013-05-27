<?php
namespace StefanoDbTest\LockStrategy;

class MysqlTest
    extends \PHPUnit_Framework_TestCase
{
    public function testGetLockSql() {
        $lockStrategy = new \StefanoDb\LockStrategy\Mysql();
        
        $actual = $lockStrategy->getLockTablesSql('table1');      
        $expected = 'LOCK TABLES table1 WRITE';
        $this->assertEquals($expected, $actual);
        
        $actual = $lockStrategy->getLockTablesSql(array('table1', 'table2'));      
        $expected = 'LOCK TABLES table1 WRITE, table2 WRITE';
        $this->assertEquals($expected, $actual);
    }
    
    public function testGetUnlockSql() {
        $lockStrategy = new \StefanoDb\LockStrategy\Mysql();
        
        $actual = $lockStrategy->getUnlockTablesSql();
        $expected = 'UNLOCK TABLES';
        $this->assertEquals($expected, $actual);
    }
}