<?php
namespace StefanoDb\Adapter;

use Zend\Db\Adapter\AdapterInterface;
use StefanoNestedTransaction\TransactionManagerInterface;

interface ExtendedAdapterInterface
    extends AdapterInterface
{
    /**
     * @return \StefanoDb\Lock\LockInterface
     */
    public function getLockAdapter();
    
    /**
     * @return TransactionManagerInterface
     */
    public function getTransaction();
}