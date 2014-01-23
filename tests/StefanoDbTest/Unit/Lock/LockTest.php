<?php
namespace StefanoDbTest\Unit\Lock;

use StefanoDb\Lock\Lock;
use \Zend\Db\Adapter\Adapter as DbAdapter;

class LockTest
    extends \PHPUnit_Framework_TestCase
{
    protected function tearDown() {
        \Mockery::close();
    }

    public function testLockTable() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->with('LOCK TABLES', DbAdapter::QUERY_MODE_EXECUTE)
                      ->once();

        $sqlBuilderMock = \Mockery::mock('StefanoLockTable\Adapter\AdapterInterface');
        $sqlBuilderMock->shouldReceive('getLockSqlString')
                       ->with('table')
                       ->andReturn('LOCK TABLES')
                       ->once();
        
        $lock = new Lock($dbAdapterMock, $sqlBuilderMock);
        $lock->lockTables('table');
    }

    public function testUnlockTable() {
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('query')
                      ->with('UNLOCK TABLES', DbAdapter::QUERY_MODE_EXECUTE)
                      ->once();

        $sqlBuilderMock = \Mockery::mock('StefanoLockTable\Adapter\AdapterInterface');
        $sqlBuilderMock->shouldReceive('getUnlockSqlString')
                       ->andReturn('UNLOCK TABLES')
                       ->once();

        $lock = new Lock($dbAdapterMock, $sqlBuilderMock);
        $lock->unlockTables();
    }

    public function testFactory() {
        $driverStub = \Mockery::mock('\Zend\Db\Adapter\Driver\Pdo\Pdo');
        $driverStub->shouldReceive('getDatabasePlatformName')
                   ->andReturn('Mysql');
        $driverStub->shouldReceive('checkEnvironment')
                   ->andReturn(true);
        
        $dbAdapterStub = new \Zend\Db\Adapter\Adapter($driverStub);

        $lock = Lock::factory($dbAdapterStub);

        $this->assertInstanceOf('\StefanoDb\Lock\LockInterface', $lock);
        $this->assertInstanceOf('\StefanoLockTable\Adapter\Mysql',
            $lock->getLockTableSqlBuilder());
    }
}