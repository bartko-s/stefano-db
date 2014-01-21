<?php
namespace StefanoDb\Transaction;

use Zend\Db\Adapter\AdapterInterface;
use StefanoNestedTransaction\Adapter\TransactionInterface;

class Adapter
    implements TransactionInterface
{
    private $dbAdapter;

    /**
     * @param AdapterInterface $dbAdapter
     */
    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function begin() {
        $this->getDbAdapter()
             ->getDriver()
             ->getConnection()
             ->beginTransaction();

        return $this;
    }

    public function commit() {
        $this->getDbAdapter()
             ->getDriver()
             ->getConnection()
             ->commit();

        return $this;
    }

    public function rollback() {
        $this->getDbAdapter()
             ->getDriver()
             ->getConnection()
             ->rollback();

        return $this;
    }

    /**
     * @return AdapterInterface
     */
    private function getDbAdapter() {
        return $this->dbAdapter;
    }
}
