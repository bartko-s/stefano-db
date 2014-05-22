<?php
namespace StefanoDb\Adapter\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\AdapterServiceFactory as ZendAdapterServiceFactory;
use StefanoDb\Adapter\AdapterFactory;

class AdapterServiceFactory
    extends ZendAdapterServiceFactory
{
    private $adapterFactory;

    /**
     * @param AdapterFactory $adapterFactory
     */
    public function __construct(AdapterFactory $adapterFactory = null) {
        $this->adapterFactory = $adapterFactory;
    }

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Config');

        return $this->getAdapterFactory()
                    ->create($config['db']);
    }

    /**
     * @return AdapterFactory
     */
    private function getAdapterFactory() {
       if(null == $this->adapterFactory) {
           $this->adapterFactory = new AdapterFactory();
       }

       return $this->adapterFactory;
    }
}