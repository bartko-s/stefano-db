<?php
namespace StefanoDbTest\LockStrategy;

class PostgresqlTest
    extends \PHPUnit_Framework_TestCase
{
    public function testGetLockSql() {
        $lockStrategy = new \StefanoDb\LockStrategy\Postgresql();
        
        $actual = $lockStrategy->getLockTablesSql('table1');      
        $expected = 'LOCK TABLE table1';
        $this->assertEquals($expected, $actual);
        
        $actual = $lockStrategy->getLockTablesSql(array('table1', 'table2'));      
        $expected = 'LOCK TABLE table1, table2';
        $this->assertEquals($expected, $actual);
    }
    
    public function testGetUnlockSql() {
        $lockStrategy = new \StefanoDb\LockStrategy\Postgresql();
        $this->assertNull($lockStrategy->getUnlockTablesSql());
    }
}