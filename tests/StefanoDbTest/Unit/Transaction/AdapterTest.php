<?php
namespace StefanoDbTest\Transaction;

use StefanoDb\Transaction\Adapter;
use StefanoNestedTransaction\Adapter\TransactionInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ConnectionInterface;
use Zend\Db\Adapter\Driver\DriverInterface;

class AdapterTest
    extends \PHPUnit_Framework_TestCase
{    
    /**
     * 
     * @param ConnectionInterface $connectionMock
     * @return AdapterInterface
     */
    private function getDbAdapterMock(ConnectionInterface $connectionMock = null) {
        $driverMock = \Mockery::mock(DriverInterface::class);
        $driverMock->shouldReceive('getConnection')
                   ->andReturn($connectionMock);
        
        $dbAdapterMock = \Mockery::mock(AdapterInterface::class);
        $dbAdapterMock->shouldReceive('getDriver')
                      ->andReturn($driverMock);
        
        return $dbAdapterMock;
    }

    public function testImplementsRequiredInterface() {
        $dbAdapterStub = \Mockery::mock(AdapterInterface::class);
        $adapter = new Adapter($dbAdapterStub);

        $this->assertInstanceOf(TransactionInterface::class,
            $adapter);
    }
    
    public function testBeginTransaction() {
        $connectionMock = \Mockery::mock(ConnectionInterface::class);
        $connectionMock->shouldReceive('beginTransaction')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Adapter($dbAdapterMock);
        $transaction->begin();        
    }    
    
    public function testCommitTransaction() {
        $connectionMock = \Mockery::mock(ConnectionInterface::class);
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('commit')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
                
        $transaction = new Adapter($dbAdapterMock);
        
        $transaction->commit();        
    }
    
    public function testRollBackTransaction() {
        $connectionMock = \Mockery::mock(ConnectionInterface::class);
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('rollback')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Adapter($dbAdapterMock);
        
        $transaction->rollback();        
    }    
}