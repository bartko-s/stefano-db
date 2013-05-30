<?php
namespace StefanoDb\Transaction;

interface TransactionInterface
{
    /**
     * Begin transaction if nested transaction has not been opened yet
     * @return self
     */
    public function begin();
    
    /**
     * Commit transaction if nested transaction has not been opened yet
     * @return self
     */
    public function commit();
    
    /**
     * Roolback transaction
     * @return self
     */
    public function rollback();
    
    /**
     * Return true if transaction is opened
     * @return boolean
     */
    public function isInTransaction();
}