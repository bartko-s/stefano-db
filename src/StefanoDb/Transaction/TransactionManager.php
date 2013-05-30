<?php
namespace StefanoDb\Transaction;

use StefanoDb\Transaction\Transaction as Transaction;
use StefanoDb\Transaction\TransactionManagerInterface;
use Zend\Db\Adapter\AdapterInterface;

class TransactionManager
    implements TransactionManagerInterface
{
    private $transactions = array();
    
    public function getTransaction(AdapterInterface $dbAdapter) {
        $dbAdapterId = spl_object_hash($dbAdapter);
        
        if(!array_key_exists($dbAdapterId, $this->transactions)) {
            $this->transactions[$dbAdapterId] = new Transaction($dbAdapter);
        }
        
        return $this->transactions[$dbAdapterId];
    }
}