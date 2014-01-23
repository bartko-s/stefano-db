<?php
namespace StefanoDb\Lock;

use StefanoDb\Lock\LockInterface;
use StefanoLockTable\Adapter\AdapterInterface as LockTableSqlBuilder;
use StefanoLockTable\Factory as LockTableFactory;
use Zend\Db\Adapter\Adapter as DbAdapter;

class Lock
    implements LockInterface
{
    private $dbAdapter;
    private $lockTableSqlBuilder;

    /**
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     * @return LockInterface
     */
    public static function factory(DbAdapter $dbAdapter) {
        $platformName = $dbAdapter->getDriver()
                                  ->getDatabasePlatformName();

        $lockTableFactory = new LockTableFactory();
        $lockTableSqlBuilder = $lockTableFactory->createAdapter($platformName);

        return new self($dbAdapter, $lockTableSqlBuilder);
    }

    public function __construct(DbAdapter $dbAdapter, LockTableSqlBuilder $lockTableSqlBuilder) {
        $this->dbAdapter = $dbAdapter;
        $this->lockTableSqlBuilder = $lockTableSqlBuilder;
    }

    public function lockTables($tables) {
        $sql = $this->getLockTableSqlBuilder()
                    ->getLockSqlString($tables);

        $this->executeSql($sql);

        return $this;
    }

    public function unlockTables() {
        $sql = $this->getLockTableSqlBuilder()
                    ->getUnlockSqlString();

        $this->executeSql($sql);

        return $this;
    }

    /**
     * @param string|null $sql
     */
    private function executeSql($sql) {
        if(null != $sql) {
            $this->getDbAdapter()
             ->query($sql, DbAdapter::QUERY_MODE_EXECUTE);
        }
    }

    /**
     * @return DbAdapter
     */
    public function getDbAdapter() {
        return $this->dbAdapter;
    }

    /**
     * @return LockTableSqlBuilder
     */
    public function getLockTableSqlBuilder() {
        return $this->lockTableSqlBuilder;
    }
}
