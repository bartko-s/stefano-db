<?php
namespace StefanoDb\Adapter;

use StefanoDb\Adapter\ExtendedAdapterInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;
use StefanoNestedTransaction\TransactionManager;
use StefanoNestedTransaction\TransactionManagerInterface;
use StefanoDb\Transaction\Adapter as TransactionAdapter;

class Adapter
    extends DbAdapter
    implements ExtendedAdapterInterface
{
    private $transaction;

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

    public function begin() {
        $this->getTransaction()
             ->begin();
    }

    public function commit() {
        $this->getTransaction()
             ->commit();
    }

    public function rollback() {
        $this->getTransaction()
             ->rollback();
    }
}