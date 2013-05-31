<?php
namespace StefanoDbTest\Lock\Adapter;

use StefanoDb\Lock\Adapter\Mysql as MysqlLockAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;

class MysqlTest
    extends \PHPUnit_Framework_TestCase
{            
    public function testLockOneTable() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->with('LOCK TABLES table-name WRITE', DbAdapter::QUERY_MODE_EXECUTE)
                      ->once();
        
        $lockAdapter = new MysqlLockAdapter($dbAdapterMock);
        $lockAdapter->lockTables('table-name');
    }
    
    public function testLockManyTables() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->with('LOCK TABLES table-name-1 WRITE, table-name-2 WRITE',
                              DbAdapter::QUERY_MODE_EXECUTE)
                      ->once();
        
        $lockAdapter = new MysqlLockAdapter($dbAdapterMock);
        $lockAdapter->lockTables(array(
            'table-name-1',
            'table-name-2'
        ));
    }
    
    public function testUnlockTables() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->with('UNLOCK TABLES', DbAdapter::QUERY_MODE_EXECUTE)
                      ->once();
        
        $lockAdapter = new MysqlLockAdapter($dbAdapterMock);
        $lockAdapter->unlockTables();
    }
}