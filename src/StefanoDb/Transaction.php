<?php
namespace StefanoDb;

use Zend\Db\Adapter\Adapter;

class Transaction
{
    protected $numberOfOpenedTransaction = 0;
    
    protected $dbAdapter;
    
    /**
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     */
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }
    
    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    protected function getDbAdapter() {
        return $this->dbAdapter;
    }

    /**
     * Begin transaction if it is not opened
     */
    public function begin() {
        if(0 == $this->getNumberOfOpenedTransaction()) {
            $this->getDbAdapter()
                 ->getDriver()
                 ->getConnection()
                 ->beginTransaction();
        }
        $this->increaseNumberOfOpenedTransaction();
    }
    
    /**
     * Commit transaction if nested transaction is not opened
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
    }
    
    /**
     * Roolback transaction
     */
    public function roolBack() {
        if(0 < $this->getNumberOfOpenedTransaction()) {
            $this->getDbAdapter()
                 ->getDriver()
                 ->getConnection()
                 ->rollback();
            
            $this->resetNumberOfOpenedTransaction();
        }
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
    protected function getNumberOfOpenedTransaction() {
        return $this->numberOfOpenedTransaction;
    }
    
    protected function resetNumberOfOpenedTransaction() {
        $this->numberOfOpenedTransaction = 0;
    }
    
    protected function increaseNumberOfOpenedTransaction() {
        $this->numberOfOpenedTransaction++;
    }
    
    protected function decreaseNumberOfOpenedTransaction() {
        $this->numberOfOpenedTransaction--;
    }
}