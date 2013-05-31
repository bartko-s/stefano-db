<?php
namespace StefanoDb\Lock\Adapter;

use StefanoDb\Lock\LockInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;

abstract class AbstractAdapter
    implements LockInterface
{
    private $dbAdapter;
    
    public function __construct(DbAdapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }
    
    
    protected function querySql($sql) {
        $this->dbAdapter
             ->query($sql, DbAdapter::QUERY_MODE_EXECUTE);        
    }    
}