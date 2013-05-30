<?php
namespace StefanoDbTest\Transaction;

use StefanoDb\Transaction\TransactionManager;

class TransactionManagerTest
    extends \PHPUnit_Framework_TestCase
{   
    public function testCanGetTransactionInstance() {
        $dbAdapterStub = \Mockery::mock('\Zend\Db\Adapter\AdapterInterface');
        
        $transactionManager = new TransactionManager();
        $transaction = $transactionManager->getTransaction($dbAdapterStub);
        
        $this->assertInstanceOf('\StefanoDb\Transaction\TransactionInterface', $transaction);
    }
    
    public function testGetSameTransactionObjectForSameDbAdapter() {
        $dbAdapterStub = \Mockery::mock('\Zend\Db\Adapter\AdapterInterface');
        
        $transactionManager = new TransactionManager();
        $this->assertSame($transactionManager->getTransaction($dbAdapterStub),
                $transactionManager->getTransaction($dbAdapterStub));
    }
    
    public function testCanManageMuchTransactionInstance() {
        $dbAdapterStub1 = \Mockery::mock('\Zend\Db\Adapter\AdapterInterface');
        $dbAdapterStub2 = \Mockery::mock('\Zend\Db\Adapter\AdapterInterface');
        
        $transactionManager = new TransactionManager();
        $transaction1 = $transactionManager->getTransaction($dbAdapterStub1);
        $transaction2 = $transactionManager->getTransaction($dbAdapterStub2);
        
        $this->assertNotSame($transaction1, $transaction2);
    }
}