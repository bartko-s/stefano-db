<?php
namespace StefanoDb\Adapter;

use StefanoDb\Adapter\ExtendedAdapterInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;
use StefanoDb\Lock\LockFactory;
use StefanoDb\Lock\LockInterface;
use StefanoNestedTransaction\TransactionManager;
use StefanoNestedTransaction\TransactionManagerInterface;
use StefanoDb\Transaction\Adapter as TransactionAdapter;

class Adapter
    extends DbAdapter
    implements ExtendedAdapterInterface
{
    private $lockAdapter;
    private $transaction;
    
    /**
     * @param \StefanoDb\Lock\LockInterface $lockAdapter
     * @return this
     */
    public function setLockAdapter(LockInterface $lockAdapter) {
        $this->lockAdapter = $lockAdapter;
        return $this;
    }
    
    public function getLockAdapter() {
        if(null === $this->lockAdapter) {
            $lockFactory = new LockFactory();
            $this->lockAdapter = $lockFactory->getLockAdapter($this);
        }
        
        return $this->lockAdapter;
    }
    
    /**
     * @param TransactionManagerInterface $transactionManager
     * @return this
     */
    public function setTransaction(TransactionManagerInterface $transactionManager) {
        $this->transaction = $transactionManager;
        return $this;
    }
    
    public function getTransaction() {
        if(null == $this->transaction) {
            $transactionAdapter = new TransactionAdapter($this);
            $this->transaction = new TransactionManager($transactionAdapter);
        }
        
        return $this->transaction;
    }
}