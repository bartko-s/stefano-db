<?php
namespace StefanoDbTest\Transaction;

use StefanoDb\Transaction\Adapter;

class AdapterTest
    extends \PHPUnit_Framework_TestCase
{    
    /**
     * 
     * @param \Zend\Db\Adapter\Driver\ConnectionInterface $connectionMock
     * @return \Zend\Db\Adapter\AdapterInterface
     */
    private function getDbAdapterMock(\Zend\Db\Adapter\Driver\ConnectionInterface $connectionMock = null) {
        $driverMock = \Mockery::mock('\Zend\Db\Adapter\Driver\DriverInterface');
        $driverMock->shouldReceive('getConnection')
                   ->andReturn($connectionMock);
        
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\AdapterInterface');
        $dbAdapterMock->shouldReceive('getDriver')
                      ->andReturn($driverMock);
        
        return $dbAdapterMock;
    }

    public function testImplementsRequiredInterface() {
        $dbAdapterStub = \Mockery::mock('Zend\Db\Adapter\AdapterInterface');
        $adapter = new Adapter($dbAdapterStub);

        $this->assertInstanceOf('StefanoNestedTransaction\Adapter\TransactionInterface',
            $adapter);
    }
    
    public function testBeginTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Adapter($dbAdapterMock);
        $transaction->begin();        
    }    
    
    public function testCommitTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('commit')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
                
        $transaction = new Adapter($dbAdapterMock);
        
        $transaction->commit();        
    }
    
    public function testRoolBackTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('rollback')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Adapter($dbAdapterMock);
        
        $transaction->rollback();        
    }    
}