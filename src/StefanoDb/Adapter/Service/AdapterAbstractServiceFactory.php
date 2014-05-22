<?php
namespace StefanoDb\Adapter\Service;

use Zend\Db\Adapter\AdapterAbstractServiceFactory as ZendAdapterAbstractServiceFactory;
use StefanoDb\Adapter\AdapterFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdapterAbstractServiceFactory
    extends ZendAdapterAbstractServiceFactory
{
    private $adapterFactory;

    /**
     * @param AdapterFactory $adapterFactory
     */
    public function __construct(AdapterFactory $adapterFactory = null) {
        $this->adapterFactory = $adapterFactory;
    }

    public function createServiceWithName(ServiceLocatorInterface $services, $name, $requestedName) {
        $config = $this->getConfig($services);

        return $this->getAdapterFactory()
                    ->create($config[$requestedName]);
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
