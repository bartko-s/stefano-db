<?php
namespace StefanoDb\Adapter\Service;

use Interop\Container\ContainerInterface;
use StefanoDb\Adapter\AdapterFactory;
use Zend\Db\Adapter\AdapterAbstractServiceFactory as ZendAdapterAbstractServiceFactory;

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

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $config = $this->getConfig($container);

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
