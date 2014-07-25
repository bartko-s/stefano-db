<?php
namespace StefanoDb\Adapter;

use Zend\Db\Adapter\AdapterInterface;

interface ExtendedAdapterInterface
    extends AdapterInterface
{
    /**
     * Begin nested transaction
     * @return void
     */
    public function begin();

    /**
     * Commit nested transaction
     * @return void
     */
    public function commit();

    /**
     * Roolback nested transaction
     * @return void
     */
    public function rollback();
}