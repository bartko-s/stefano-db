<?php
namespace StefanoDbTest\Unit\Adapter;

use StefanoDb\Adapter\Adapter;
use StefanoNestedTransaction\TransactionManager;

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
        $this->assertInstanceOf('\StefanoDb\Lock\Lock',
            $dbAdapter->getLockAdapter());
        $this->assertSame($dbAdapter->getLockAdapter(), $dbAdapter->getLockAdapter()); //return same object
    }
    
    public function testSetGetTransaction() {
        $transactionStub = \Mockery::mock('\StefanoDb\Transaction\Adapter');

        $transaction = new TransactionManager($transactionStub);
        
        $dbAdapter = $this->adapter;
        $dbAdapter->setTransaction($transaction);
        $this->assertSame($transaction, $dbAdapter->getTransaction());
    }
    
    public function testLazyLoadedTransaction() {
        $dbAdapter = $this->adapter;
        $this->assertInstanceOf('\StefanoNestedTransaction\TransactionManagerInterface',
                $dbAdapter->getTransaction());
        $this->assertSame($dbAdapter->getTransaction(), $dbAdapter->getTransaction()); //return same object
    }
}