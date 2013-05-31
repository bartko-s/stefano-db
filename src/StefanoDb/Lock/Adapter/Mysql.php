<?php
namespace StefanoDb\Lock\Adapter;

use StefanoDb\Lock\Adapter\AbstractAdapter as AbstractLockAdapter;

class Mysql
    extends AbstractLockAdapter
{    
    public function lockTables($tables) {
        if(is_array($tables)) {
            foreach ($tables as &$table) {
                $table = $table . ' WRITE';
            }
            $sqlPart = implode(', ', $tables);
        } else {
            $sqlPart = $tables . ' WRITE';
        }
        
        $sql = 'LOCK TABLES ' . (string) $sqlPart;
        
        $this->querySql($sql);
        return $this;
    }

    public function unlockTables() {
        $this->querySql('UNLOCK TABLES');
        return $this;
    }    
}