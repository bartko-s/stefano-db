<?php
namespace StefanoDb;

use Zend\Db\Adapter\Adapter;

class Transaction
{
    private $numberOfOpenedTransaction = 0;
    
    private $dbAdapter;
    
    /**
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     */
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }
    
    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    private function getDbAdapter() {
        return $this->dbAdapter;
    }

    /**
     * Begin transaction if it is not opened
     * @return \StefanoDb\Transaction
     */
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
    
    /**
     * Commit transaction if nested transaction is not opened
     * @return \StefanoDb\Transaction
     */
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
    
    /**
     * Roolback transaction
     * @return \StefanoDb\Transaction
     */
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
    
    /**
     * Retrun true if transaction is opened
     * @return boolean
     */
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