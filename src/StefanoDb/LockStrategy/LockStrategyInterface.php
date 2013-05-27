<?php
namespace StefanoDb\LockStrategy;

interface LockStrategyInterface
{
    /**
     * @param string|array $tables
     * @return null|string
     */
    public function getLockTablesSql($tables);
    
    /**
     * @return null|string
     */
    public function getUnlockTablesSql();
}