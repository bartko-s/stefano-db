<?php
namespace StefanoDb\LockStrategy;

use StefanoDb\LockStrategy\LockStrategyInterface;

class Postgresql
    implements LockStrategyInterface
{
    public function getLockTablesSql($tables) {
        if(is_array($tables)) {
            $tables = implode(', ', $tables);
        }
        
        return 'LOCK TABLE ' . (string) $tables;
    }

    public function getUnlockTablesSql() {
        //postres does not support unlock
        return null;
    }    
}