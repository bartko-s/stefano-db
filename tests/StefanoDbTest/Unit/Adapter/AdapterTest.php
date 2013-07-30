<?php
namespace StefanoDbTest\Unit\Adapter;

use StefanoDb\Adapter\Adapter;

class AdapterTest
    extends \PHPUnit_Framework_TestCase
{   
    /**
     * @var \StefanoDb\Adapter\Adapter
     */
    protected $adapter;
    
    protected function setUp() {
        $driverStub = \Mockery::mock('\Zend\Db\Adapter\Driver\Pdo\Pdo');
        $driverStub->shouldReceive('getDatabasePlatformName')
                   ->andReturn('Mysql');
        $driverStub->shouldReceive('checkEnvironment')
                   ->andReturn(true);
        
        $this->adapter = new Adapter($driverStub);
    }
    
    protected function tearDown() {
        $this->adapter = null;
    }
    
    public function testImplementsExtendedAdapterInterface() {
        $this->assertInstanceOf('\StefanoDb\Adapter\ExtendedAdapterInterface', $this->adapter);
    }
    
    public function testSetGetLockAdapter() {
        $lockAdapterStub = \Mockery::mock('\StefanoDb\Lock\LockInterface');
        
        $dbAdapter = $this->adapter;
        $dbAdapter->setLockAdapter($lockAdapterStub);
        $this->assertSame($lockAdapterStub, $dbAdapter->getLockAdapter());
    }
    
    public function testLazyLoadedLockAdapter() {
        $dbAdapter = $this->adapter;
        $this->assertInstanceOf('\StefanoDb\Lock\Adapter\Mysql', $dbAdapter->getLockAdapter());
        $this->assertSame($dbAdapter->getLockAdapter(), $dbAdapter->getLockAdapter()); //return same object
    }
    
    public function testSetGetTransaction() {
        $transactionStub = \Mockery::mock('\StefanoDb\Transaction\TransactionInterface');
        
        $dbAdapter = $this->adapter;
        $dbAdapter->setTransaction($transactionStub);
        $this->assertSame($transactionStub, $dbAdapter->getTransaction());
    }
    
    public function testLazyLoadedTransaction() {
        $dbAdapter = $this->adapter;
        $this->assertInstanceOf('\StefanoDb\Transaction\TransactionInterface',
                $dbAdapter->getTransaction());
        $this->assertSame($dbAdapter->getTransaction(), $dbAdapter->getTransaction()); //return same object
    }
}