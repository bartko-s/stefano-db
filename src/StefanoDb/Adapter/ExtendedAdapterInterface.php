<?php
namespace StefanoDb\Adapter;

interface ExtendedAdapterInterface    
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