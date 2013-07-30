<?php
namespace StefanoDb\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\Db\Adapter\AdapterAwareInterface as ZendDbAdapterAwareInterface;
use StefanoDb\Adapter\AdapterAwareInterface as StefanoDbAdapterAwareInterface;

class DbInitializer
    implements InitializerInterface
{
    public function initialize($instance, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        if($instance instanceof ZendDbAdapterAwareInterface ||
                $instance instanceof StefanoDbAdapterAwareInterface) {
            $dbAdapter = $serviceLocator->get('StefanoDb\Adapter\Adapter');
            $instance->setDbAdapter($dbAdapter);
        }
    }
}