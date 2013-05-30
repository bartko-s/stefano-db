<?php
namespace StefanoDbTest;

use \StefanoDb\Transaction;

class TransactionTest
    extends \PHPUnit_Framework_TestCase
{    
    private function getDbAdapterMock(\Zend\Db\Adapter\Driver\ConnectionInterface $connectionMock = null) {
        $driverMock = \Mockery::mock('\Zend\Db\Adapter\Driver\DriverInterface');
        $driverMock->shouldReceive('getConnection')
                   ->andReturn($connectionMock);
        
        $dbAdapterMock = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterMock->shouldReceive('getDriver')
                      ->andReturn($driverMock);
        
        return $dbAdapterMock;
    }
    
    public function testCanBeginTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Transaction($dbAdapterMock);
        
        $transaction->begin();        
    }    
    
    public function testCanCommitTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('commit')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
                
        $transaction = new Transaction($dbAdapterMock);
        
        $transaction->begin()
                    ->commit();        
    }
    
    public function testCanRoolBackTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('rollback')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Transaction($dbAdapterMock);
        
        $transaction->begin()
                    ->roolBack();        
    }
    
    public function testCanBeginNestedTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Transaction($dbAdapterMock);
        
        $transaction->begin()
                    ->begin()
                    ->begin();
    }
    
    public function testCanCommitNestedTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('commit')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Transaction($dbAdapterMock);
        
        $transaction->begin()
                    ->begin()
                    ->commit()
                    ->begin()
                    ->commit()
                    ->commit();
    }
    
    public function testCanRollbackNestedTransaction() {
        $connectionMock = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionMock->shouldReceive('beginTransaction');
        $connectionMock->shouldReceive('rollback')
                       ->once();
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionMock);
        
        $transaction = new Transaction($dbAdapterMock);
        
        $transaction->begin()
                    ->begin()
                    ->roolBack();        
    }    
    
    /**
     * @depends testCanCommitNestedTransaction
     * @depends testCanBeginNestedTransaction
     */
    public function testIsInTransaction() {
        $connectionStub = \Mockery::mock('\Zend\Db\Adapter\Driver\ConnectionInterface');
        $connectionStub->shouldReceive('beginTransaction');
        $connectionStub->shouldReceive('commit');
        
        $dbAdapterMock = $this->getDbAdapterMock($connectionStub);
        
        $transaction = new Transaction($dbAdapterMock);
        
        $this->assertFalse($transaction->isInTransaction());
        $transaction->begin()
                    ->begin();
        $this->assertTrue($transaction->isInTransaction());
        $transaction->commit();
        $this->assertTrue($transaction->isInTransaction());
        $transaction->commit();
        $this->assertFalse($transaction->isInTransaction());
    }
}