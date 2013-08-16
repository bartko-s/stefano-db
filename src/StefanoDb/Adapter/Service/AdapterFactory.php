<?php
namespace StefanoDb\Adapter\Service;

use Zend\ServiceManager\FactoryInterface;
use StefanoDb\Adapter\Adapter;

class AdapterFactory
    implements FactoryInterface
{
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Configuration');
        
        $dbAdapter = new Adapter($config['db']);
        
        if(array_key_exists('sqls', $config['stefano_db'])) {
            foreach($config['stefano_db']['sqls'] as $sql) {
                $dbAdapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
            }
        }
        
        return $dbAdapter;
    }    
}