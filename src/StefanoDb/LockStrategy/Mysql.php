<?php
namespace StefanoDb\LockStrategy;

use StefanoDb\LockStrategy\LockStrategyInterface;

class Mysql
    implements LockStrategyInterface
{
    public function getLockTablesSql($tables) {
        if(is_array($tables)) {
            foreach($tables as &$table) {
                $table = $table . ' WRITE';
            }
            
            $tables = implode(', ', $tables);
        } else {
            $tables = $tables . ' WRITE';
        }
        
        return 'LOCK TABLES ' . (string) $tables;
    }

    public function getUnlockTablesSql() {
        return 'UNLOCK TABLES';
    }    
}