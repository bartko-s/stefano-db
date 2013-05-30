<?php
namespace StefanoDbTest;

use \StefanoDb\Transaction\TransactionManager;
use \Zend\Db\Adapter\Adapter;

class TransactionManagerTest
    extends \PHPUnit_Framework_TestCase
{
    private $dbAdapter;
    
    private $dbAdapter2;

    protected function setUp() {
        $this->dbAdapter = new Adapter(array(
            'driver' => 'Pdo_' . ucfirst(TEST_STEFANO_DB_ADAPTER),
            'hostname' => TEST_STEFANO_DB_HOSTNAME,
            'database' => TEST_STEFANO_DB_DB_NAME,
            'username' => TEST_STEFANO_DB_USER,
            'password' => TEST_STEFANO_DB_PASSWORD
        ));
        
        $this->dbAdapter2 = new Adapter(array(
            'driver' => 'Pdo_' . ucfirst(TEST_STEFANO_DB_ADAPTER),
            'hostname' => TEST_STEFANO_DB_HOSTNAME,
            'database' => TEST_STEFANO_DB_DB_NAME,
            'username' => TEST_STEFANO_DB_USER,
            'password' => TEST_STEFANO_DB_PASSWORD
        ));
        
        
    }
    
    protected function tearDown() {
        $this->dbAdapter = null;
        
        $this->dbAdapter2 = null;
    }
    
    public function testGetTransaction() {
        $this->assertInstanceOf('\StefanoDb\Transaction\Transaction',
                TransactionManager::getTransaction($this->dbAdapter));
        
        $transaction1 = TransactionManager::getTransaction($this->dbAdapter);
        $transaction2 = TransactionManager::getTransaction($this->dbAdapter2);
        $this->assertNotSame($transaction1, $transaction2, 'Must not be same instance');
        
        $transaction3 = TransactionManager::getTransaction($this->dbAdapter);
        $transaction4 = TransactionManager::getTransaction($this->dbAdapter);
        $this->assertSame($transaction3, $transaction4, 'Must be same instance');        
    }
}