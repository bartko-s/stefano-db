<?php
namespace StefanoDb\Adapter;

use Zend\Db\Adapter\AdapterInterface;

interface ExtendedAdapterInterface
    extends AdapterInterface
{
    /**
     * @return \StefanoDb\Lock\LockInterface
     */
    public function getLockAdapter();
    
    /**
     * @return \StefanoDb\Transaction\TransactionInterface
     */
    public function getTransaction();
}