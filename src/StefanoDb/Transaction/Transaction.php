<?php
namespace StefanoDb\Transaction;

use Zend\Db\Adapter\AdapterInterface;
use StefanoDb\Transaction\TransactionInterface;

class Transaction
    implements TransactionInterface
{
    private $numberOfOpenedTransaction = 0;
    
    private $dbAdapter;
    
    /**
     * @param \Zend\Db\Adapter\AdapterInterface $dbAdapter
     */
    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }
    
    /**
     * @return \Zend\Db\Adapter\AdapterInterface
     */
    private function getDbAdapter() {
        return $this->dbAdapter;
    }

    public function begin() {
        if(0 == $this->getNumberOfOpenedTransaction()) {
            $this->getDbAdapter()
                 ->getDriver()
                 ->getConnection()
                 ->beginTransaction();
        }
        $this->increaseNumberOfOpenedTransaction();
        
        return $this;
    }
    
    public function commit() {
        if(1 == $this->getNumberOfOpenedTransaction()) {
            $this->getDbAdapter()
                 ->getDriver()
                 ->getConnection()
                  ->commit();
        }
        
        if(0 < $this->getNumberOfOpenedTransaction()) {
            $this->decreaseNumberOfOpenedTransaction();
        }
        
        return $this;
    }
    
    public function roolBack() {
        if(0 < $this->getNumberOfOpenedTransaction()) {
            $this->getDbAdapter()
                 ->getDriver()
                 ->getConnection()
                 ->rollback();
            
            $this->resetNumberOfOpenedTransaction();
        }
        
        return $this;
    }
    
    public function isInTransaction() {
        if(0 < $this->getNumberOfOpenedTransaction()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Get number of opened transaction
     * @return int
     */
    private function getNumberOfOpenedTransaction() {
        return $this->numberOfOpenedTransaction;
    }
    
    private function resetNumberOfOpenedTransaction() {
        $this->numberOfOpenedTransaction = 0;
    }
    
    private function increaseNumberOfOpenedTransaction() {
        $this->numberOfOpenedTransaction++;
    }
    
    private function decreaseNumberOfOpenedTransaction() {
        $this->numberOfOpenedTransaction--;
    }
}