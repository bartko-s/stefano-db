<?php
namespace StefanoDb;

use Zend\Db\Adapter\Adapter as DbAdapter;

class Lock
{
    protected $dbAdapter;
    protected $lockStrategy;
    
    /**
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     */
    public function __construct(DbAdapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }
    
    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    protected function getDbAdapter() {
        return $this->dbAdapter;
    }
    
    /**
     * @return \StefanoDb\LockStrategy\LockStrategyInterface
     * @throws \Exception
     */
    protected function getLockStrategy() {
        if(null === $this->lockStrategy) {
            $dbPlatform = $this->getDbAdapter()
                               ->getDriver()
                               ->getDatabasePlatformName();
            $className = '\\' . __NAMESPACE__ . '\\LockStrategy\\' . $dbPlatform;
            
            if(class_exists($className)) {
                $this->lockStrategy = new $className();
            } else {
                throw new \Exception('Db Lock strategy "' . $dbPlatform . '" does not exist');
            }
        }
        
        return $this->lockStrategy;
    }
    
    /**
     * Execute sql only if sql is not null
     * 
     * @param string|null $sql
     * @return \StefanoDb\Lock
     */
    protected function executeQuery($sql) {
        if(null !== $sql) {        
            $this->getDbAdapter()
                 ->query($sql, DbAdapter::QUERY_MODE_EXECUTE);
        }
        return $this;
    }

    /**
     * @param string|array $tables
     * @return \StefanoDb\Lock
     */
    public function lock($tables) {
        $sql = $this->getLockStrategy()
                    ->getLockTablesSql($tables);
        $this->executeQuery($sql);
        return $this;
    }
    
    /**
     * @return \StefanoDb\Lock
     */
    public function unlock() {
        $sql = $this->getLockStrategy()
                    ->getUnlockTablesSql();
        $this->executeQuery($sql);
        return $this;
    }
}