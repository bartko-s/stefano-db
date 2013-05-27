<?php
namespace StefanoDbTest;

use \Zend\Db\Adapter\Adapter as DbAdapter;
use \StefanoDb\Transaction;

class TransactionTest
    extends \PHPUnit_Framework_TestCase
{
    protected $dbAdapter;
    
    protected function setUp() {        
        $dbAdapter = new DbAdapter(array(
            'driver' => 'Pdo_' . ucfirst(TEST_STEFANO_DB_ADAPTER),
            'hostname' => TEST_STEFANO_DB_HOSTNAME,
            'database' => TEST_STEFANO_DB_DB_NAME,
            'username' => TEST_STEFANO_DB_USER,
            'password' => TEST_STEFANO_DB_PASSWORD
        ));
        $this->dbAdapter = $dbAdapter;
    }
    
    protected function tearDown() {
        $this->dbAdapter = null;        
    }
    
    public function testBegin() {
        $transaction = new Transaction($this->dbAdapter);
        
        $this->assertFalse($transaction->isInTransaction());
        $transaction->begin();
        $this->assertTrue($transaction->isInTransaction());
    }    
    
    /**
     * @depends testBegin
     */
    public function testCommit() {
        $transaction = new Transaction($this->dbAdapter);
        
        $transaction->begin();
        $this->assertTrue($transaction->isInTransaction());
        $transaction->commit();
        $this->assertFalse($transaction->isInTransaction());        
    }
    
    /**
     * @depends testBegin
     */
    public function testRoolBack() {
        $transaction = new Transaction($this->dbAdapter);
        
        $transaction->begin();
        $this->assertTrue($transaction->isInTransaction());
        $transaction->roolBack();
        $this->assertFalse($transaction->isInTransaction());        
    }
    
    /**
     * @depends testBegin
     * @depends testCommit
     */
    public function testBeginNestedTransaction() {
        $transaction = new Transaction($this->dbAdapter);
        
        $this->assertFalse($transaction->isInTransaction());
        $transaction->begin();
        $this->assertTrue($transaction->isInTransaction());
        $transaction->begin();
        $this->assertTrue($transaction->isInTransaction()); 
        $transaction->commit();
        $this->assertTrue($transaction->isInTransaction()); 
        $transaction->commit();
        $this->assertFalse($transaction->isInTransaction()); 
    }
    
    /**
     * @depends testBegin
     * @depends testRoolBack
     */
    public function testRoolbalckNestedTransaction() {
        $transaction = new Transaction($this->dbAdapter);
        
        $this->assertFalse($transaction->isInTransaction());
        $transaction->begin();
        $this->assertTrue($transaction->isInTransaction());
        $transaction->begin();
        $this->assertTrue($transaction->isInTransaction()); 
        $transaction->roolBack();
        $this->assertFalse($transaction->isInTransaction());
        $transaction->roolBack();
        $this->assertFalse($transaction->isInTransaction());
    }    
}