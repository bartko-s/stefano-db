<?php
namespace StefanoDb\Adapter;

use StefanoDb\MultiQuery;
use StefanoDb\Adapter\Adapter;

class AdapterFactory
{
    private $multiQuery;

    /**
     * @param MultiQuery|null $multyQuery
     */
    public function __construct(MultiQuery $multyQuery = null) {
        $this->multiQuery = $multyQuery;
    }

    /**
     * @param array $config
     * @return Adapter
     */
    public function create(array $config) {
        if(array_key_exists('sqls', $config)) {
            $sqls = $config['sqls'];
            unset($config['sqls']);
        } else {
            $sqls = array();
        }

        $dbAdapter = new Adapter($config);

        $this->getMultiQuery()
             ->execute($dbAdapter, $sqls);

        return $dbAdapter;
    }

    /**
     * @return MultiQuery
     */
    public function getMultiQuery() {
        if(null == $this->multiQuery) {
            $this->multiQuery = new MultiQuery();
        }

        return $this->multiQuery;
    }
}
