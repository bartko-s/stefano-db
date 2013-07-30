<?php
namespace StefanoDb\Adapter\Service;

use Zend\ServiceManager\FactoryInterface;
use StefanoDb\Adapter\Adapter;

class AdapterFactory
    implements FactoryInterface
{
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Configuration');
        
        return new Adapter($config['db']);
    }    
}