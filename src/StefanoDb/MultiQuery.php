<?php
namespace StefanoDb;

use StefanoDb\Adapter\ExtendedAdapterInterface;
use StefanoDb\Adapter\Adapter as DbAdapter;

class MultiQuery
{
    /**
     * @param ExtendedAdapterInterface $dbAdapter
     * @param array $sqls
     */
    public function execute(ExtendedAdapterInterface $dbAdapter, array $sqls) {
        foreach($sqls as $sql) {
            $dbAdapter->query($sql, DbAdapter::QUERY_MODE_EXECUTE);
        }
    }
}
