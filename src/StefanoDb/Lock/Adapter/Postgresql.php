<?php
namespace StefanoDb\Lock\Adapter;

use StefanoDb\Lock\Adapter\AbstractAdapter as AbstractLockAdapter;

class Postgresql
    extends AbstractLockAdapter
{
    public function lockTables($tables) {
        if(is_array($tables)) {
            $sqlPart = implode(', ', $tables);
        } else {
            $sqlPart = $tables;
        }
        
        $sql = 'LOCK TABLE ' . (string) $sqlPart;
        
        $this->querySql($sql);
        
        return $this;
    }

    public function unlockTables() {
        return $this;
    }
}