<?php
namespace StefanoDb;

use StefanoDb\Transaction;
use Zend\Db\Adapter\Adapter;

class TransactionManager
{
    static private $transactions = array();
    
    /**
     * Return new instance if Transaction object does not exist for given db adapter
     * otherwise return existent object
     * 
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     * @return \StefanoDb\Transaction
     */
    static function getTransaction(Adapter $dbAdapter) {
        $dbAdapterId = spl_object_hash($dbAdapter);
        
        if(!array_key_exists($dbAdapterId, self::$transactions)) {
            self::$transactions[$dbAdapterId] = new Transaction($dbAdapter);
        }
        
        return self::$transactions[$dbAdapterId];
    }
}