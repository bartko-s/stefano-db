<?php
namespace StefanoDbTest\Lock\Adapter;

use StefanoDb\Lock\Adapter\Postgresql as PostgresqlLockAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;

class PostgresqlTest
    extends \PHPUnit_Framework_TestCase
{        
    public function testLockOneTable() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->with('LOCK TABLE table-name', DbAdapter::QUERY_MODE_EXECUTE)
                      ->once();
        
        $lockAdapter = new PostgresqlLockAdapter($dbAdapterMock);
        $lockAdapter->lockTables('table-name');
    }
    
    public function testLockManyTables() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->with('LOCK TABLE table-name-1, table-name-2',
                              DbAdapter::QUERY_MODE_EXECUTE)
                      ->once();
        
        $lockAdapter = new PostgresqlLockAdapter($dbAdapterMock);
        $lockAdapter->lockTables(array(
            'table-name-1',
            'table-name-2'
        ));
    }
    
    public function testUnlockTables() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->never();
        
        $lockAdapter = new PostgresqlLockAdapter($dbAdapterMock);
        $lockAdapter->unlockTables();
    }
}