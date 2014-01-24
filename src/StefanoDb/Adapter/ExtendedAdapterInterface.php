<?php
namespace StefanoDb\Adapter;

use Zend\Db\Adapter\AdapterInterface;
use StefanoNestedTransaction\TransactionManagerInterface;

interface ExtendedAdapterInterface
    extends AdapterInterface
{   
    /**
     * @return TransactionManagerInterface
     */
    public function getTransaction();
}