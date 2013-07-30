<?php
namespace StefanoDb\Adapter;

use StefanoDb\Adapter\ExtendedAdapterInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;
use StefanoDb\Transaction\TransactionInterface;
use StefanoDb\Transaction\Transaction;
use StefanoDb\Lock\LockFactory;
use StefanoDb\Lock\LockInterface;

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
     * @param \StefanoDb\Transaction\TransactionInterface $transaction
     * @return this
     */
    public function setTransaction(TransactionInterface $transaction) {
        $this->transaction = $transaction;
        return $this;
    }
    
    public function getTransaction() {
        if(null == $this->transaction) {
            $this->transaction = new Transaction($this);
        }
        
        return $this->transaction;
    }
}