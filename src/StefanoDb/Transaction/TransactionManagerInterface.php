<?php
namespace StefanoDb\Transaction;

use Zend\Db\Adapter\AdapterInterface;

interface TransactionManagerInterface
{
     /**
     * Return new instance of Transaction object if not exist for given db adapter
     * otherwise return existent instance
     * 
     * @param \Zend\Db\Adapter\AdapterInterface $dbAdapter
     * @return \StefanoDb\Transaction\TransactionInterface
     */
    public function getTransaction(AdapterInterface $dbAdapter);
}