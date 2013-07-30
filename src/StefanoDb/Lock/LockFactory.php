<?php
namespace StefanoDb\Lock;

use Zend\Db\Adapter\Adapter as DbAdapter;
use StefanoDb\Exception\InvalidArgumentException;

class LockFactory
{    
    /**
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     * @return \StefanoDb\Lock\LockInterface
     * @throws InvalidArgumentException
     */
    public function getLockAdapter(DbAdapter $dbAdapter) {
        $platformName = $dbAdapter->getDriver()
                                  ->getDatabasePlatformName();
        
        $adapterClassName = __NAMESPACE__ . '\\Adapter\\' . ucfirst($platformName);
        
        if(class_exists($adapterClassName)) {
            return new $adapterClassName($dbAdapter);
        } else {
            throw new InvalidArgumentException('Lock Adapter for "' . $platformName . '" does not exist');
        }
    }
}