<?php
namespace StefanoDb\Lock;

interface LockInterface
{
    /**
     * Exclusive Lock table or tables
     * @param string|array $tables table name or array of tables
     * @return self
     */
    public function lockTables($tables);
    
    /**
     * Unlock tables
     * @return self
     */
    public function unlockTables();
}